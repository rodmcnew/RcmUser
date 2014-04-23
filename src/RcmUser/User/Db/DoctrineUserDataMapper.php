<?php
/**
 * DoctrineUserDataMapper.php
 *
 * DoctrineUserDataMapper
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Db;


use Doctrine\ORM\EntityManager;
use RcmUser\Db\DoctrineMapper;
use RcmUser\User\Entity\DoctrineUser;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;

/**
 * Class DoctrineUserDataMapper
 *
 * DoctrineUserDataMapper
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class DoctrineUserDataMapper
    extends AbstractUserDataMapper
    implements UserDataMapperInterface
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var
     */
    protected $entityClass;

    /**
     * setEntityManager
     *
     * @param EntityManager $entityManager entityManager
     *
     * @return void
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * getEntityManager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {

        return $this->entityManager;
    }

    /**
     * setEntityClass
     *
     * @param string $entityClass entityClass namespace
     *
     * @return void
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = (string)$entityClass;
    }

    /**
     * getEntityClass
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * fetchById
     *
     * @param mixed $id
     *
     * @return Result
     */
    public function fetchById($id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT user FROM ' . $this->getEntityClass() . ' user ' .
            'WHERE user.id = ?1 '
        );
        $query->setParameter(1, $id);

        $users = $query->getResult();

        if (empty($users) || !isset($users[0])) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User could not be found by id.'
            );
        }

        $user = $users[0];

        // This is so we get a fresh user every time
        $this->getEntityManager()->refresh($user);

        return new Result($user);
    }

    /**
     * fetchByUsername
     *
     * @param string $username
     *
     * @return Result
     */
    public function fetchByUsername($username)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT user FROM ' . $this->getEntityClass() . ' user ' .
            'WHERE user.username = ?1 '
        );
        $query->setParameter(1, $username);


        $users = $query->getResult();

        if (empty($users) || !isset($users[0])) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User could not be found by username.'
            );
        }

        $user = $users[0];

        // This is so we get a fresh user every time
        $this->getEntityManager()->refresh($user);

        return new Result($user);
    }

    /**
     * create
     *
     * @param User $newUser
     * @param User $creatableUser
     *
     * @return \RcmUser\User\Result
     */
    public function create(User $newUser, User $creatableUser)
    {
        /* VALIDATE */
        $result = $this->getUserValidator()->validateCreateUser(
            $newUser,
            $creatableUser
        );

        if(!$result->isSuccess()){

            return $result;
        }

        /* PREPARE */
        // make sure no duplicates
        $dupUser = $this->fetchByUsername(
            $newUser->getUsername()
        );

        if ($dupUser->isSuccess()) {

            // ERROR - user exists
            return new Result(
                null,
                Result::CODE_FAIL,
                'User could not be prepared, duplicate username.'
            );
        }

        $result = $this->getUserDataPreparer()->prepareUserCreate(
            $newUser,
            $creatableUser
        );

        if(!$result->isSuccess()){

            return $result;
        }

        /* SAVE */
        $user = $result->getUser();

        $creatableUser = $this->getValidInstance($user);

        // @todo if error, fail with null
        $this->getEntityManager()->persist($creatableUser);
        $this->getEntityManager()->flush();

        return new Result($creatableUser);
    }

    /**
     * read
     *
     * @param User $readUser
     * @param User $readableUser
     *
     * @return mixed|Result
     */
    public function read(User $readUser, User $readableUser)
    {
        $id = $readUser->getId();

        if (!empty($id)) {

            $result = $this->fetchById($id);

            if ($result->isSuccess()) {

                return $result;
            }
        }

        $username = $readUser->getUsername();

        if (!empty($username)) {

            $result = $this->fetchByUsername($username);

            return $result;
        }

        return new Result(null, Result::CODE_FAIL, 'User can not be read.');
    }

    /**
     * update
     *
     * @param User $updatedUser
     * @param User $updatableUser
     * @param User $existingUser
     *
     * @return \RcmUser\User|Result
     */
    public function update(User $updatedUser, User $updatableUser, User $existingUser)
    {
        /* VALIDATE */
        if (!$this->canUpdate($updatedUser)) {

            // error, cannot update
            return new Result(
                null,
                Result::CODE_FAIL,
                'User cannot be updated, id required for update.'
            );
        }

        // USERNAME CHECKS
        $updatedUsername = $updatedUser->getUsername();
        $existingUserName = $existingUser->getUsername();

        // if username changed:
        if ($existingUserName !== $updatedUsername) {

            // make sure no duplicates
            $dupUser = $this->fetchByUsername($updatedUsername);

            if ($dupUser->isSuccess()) {

                // ERROR - user exists
                return new Result(
                    null,
                    Result::CODE_FAIL,
                    'User could not be prepared, duplicate username.'
                );
            }

            $updatableUser->setUsername($updatedUsername);
        }

        $result = $this->getUserValidator()->validateUpdateUser(
            $updatedUser,
            $updatableUser,
            $existingUser
        );

        if(!$result->isSuccess()){

            return $result;
        }

        /* PREPARE */
        $result = $this->getUserDataPreparer()->prepareUserUpdate(
            $updatedUser,
            $updatableUser,
            $existingUser
        );

        if(!$result->isSuccess()){

            return $result;
        }

        /* SAVE */
        $user = $this->getValidInstance($updatableUser);

        // @todo if error, fail with null
        $this->getEntityManager()->merge($user);
        $this->getEntityManager()->flush();

        return new Result($user);
    }

    /**
     * delete
     *
     * @param User $deleteUser
     * @param User $deletableUser
     *
     * @return mixed|Result
     */
    public function delete(User $deleteUser, User $deletableUser)
    {
        /* VALIDATE */
        if (!$this->canUpdate($deleteUser)) {

            // error, cannot update
            return new Result(
                null,
                Result::CODE_FAIL,
                'User cannot be deleted (disabled), id required for delete.'
            );
        }

        /* PREPARE */
        $deletableUser->setState(User::STATE_DISABLED);

        /* SAVE */
        $deletableUser = $this->getValidInstance($deletableUser);

        // @todo if error, fail with null
        $this->getEntityManager()->merge($deletableUser);
        /* by default, we should not support true delete
        $this->getEntityManager()->remove($user);
        */
        $this->getEntityManager()->flush();

        return new Result($deletableUser);
    }

    /**
     * getValidInstance
     *
     * @param User $user user
     *
     * @return User
     */
    public function getValidInstance(User $user)
    {
        if (!($user instanceof DoctrineUser)) {

            $doctrineUser = new DoctrineUser();
            $doctrineUser->populate($user);

            $user = $doctrineUser;
        }

        return $user;
    }
} 