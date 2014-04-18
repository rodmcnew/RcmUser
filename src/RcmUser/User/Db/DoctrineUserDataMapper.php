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
class DoctrineUserDataMapper extends DoctrineMapper implements
    UserDataMapperInterface
{
    /**
     * fetchById
     *
     * @param mixed $id     id
     * @param array $params params
     *
     * @return Result
     */
    public function fetchById($id, $params = array())
    {
        //$user = $this->getEntityManager()->find($this->getEntityClass(), $id);

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
     * @param string $username username
     * @param array  $params   params
     *
     * @return Result
     */
    public function fetchByUsername($username, $params = array())
    {
        //$user = $this->getEntityManager()->getRepository(
        //    $this->getEntityClass())->findOneBy(array('username' => $username)
        //);

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
     * @param User  $user   user
     * @param array $params params
     *
     * @return Result
     */
    public function create(User $user, $params = array())
    {
        $result = $this->getValidInstance($user);

        $user = $result->getUser();

        // @todo if error, fail with null
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return new Result($user);
    }

    /**
     * read
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return Result
     */
    public function read(User $user, $params = array())
    {
        $result = $this->getValidInstance($user);

        $user = $result->getUser();
        $id = $user->getId();

        if (!empty($id)) {

            $result = $this->fetchById($id);

            if ($result->isSuccess()) {

                return $result;
            }
        }

        $username = $user->getUsername();

        if (!empty($username)) {

            $result = $this->fetchByUsername($username);

            return $result;
        }

        return new Result(null, Result::CODE_FAIL, 'User can not be read.');
    }

    /**
     * update
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return Result
     */
    public function update(User $user, $params = array())
    {
        $result = $this->getValidInstance($user);

        $user = $result->getUser();

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new Result(
                null,
                Result::CODE_FAIL,
                'User cannot be updated, id required for update.'
            );
        }

        // @todo if error, fail with null
        $this->getEntityManager()->merge($user);
        $this->getEntityManager()->flush();

        return new Result($user);
    }

    /**
     * delete
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return Result
     */
    public function delete(User $user, $params = array())
    {

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new Result(
                null,
                Result::CODE_FAIL,
                'User cannot be deleted (disabled), id required for delete.'
            );
        }

        $user->setState(User::STATE_DISABLED);

        $updateResult = $this->update($user);

        if (!$updateResult->isSuccess()) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User cannot be deleted (disabled). ' . $updateResult->getMessage()
            );
        }

        return new Result(
            $updateResult->getUser(),
            Result::CODE_SUCCESS,
            'User deleted (disabled) successfully.'
        );
        /* by default, we should not support true delete
        $result = $this->getValidInstance($user);

        $user = $result->getUser();

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new Result(
                null,
                Result::CODE_FAIL,
                'User cannot be deleted, id required for delete.'
            );
        }

        //  if error, fail with null
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();

        return new Result($user);
        */
    }

    /**
     * getValidInstance
     *
     * @param User $user user
     *
     * @return Result
     */
    public function getValidInstance(User $user)
    {

        if (!($user instanceof DoctrineUser)) {

            $doctrineUser = new DoctrineUser();
            $doctrineUser->populate($user);

            $user = $doctrineUser;
        }

        return new Result($user);
    }

    /**
     * canUpdate
     *
     * @param User $user user
     *
     * @return bool
     */
    public function canUpdate(User $user)
    {

        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        return true;
    }

    /**
     * parseParamValue
     *
     * @param string $key    key
     * @param array  $params params
     *
     * @return mixed
     */
    protected function parseParamValue($key, $params = array())
    {

        if (isset($params[$key])) {

            return $params[$key];
        }

        return null;
    }
} 