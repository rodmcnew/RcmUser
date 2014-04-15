<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Db;


use RcmUser\Db\DoctrineMapper;
use RcmUser\User\Entity\DoctrineUser;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;

class DoctrineUserDataMapper extends DoctrineMapper implements UserDataMapperInterface
{
    /**
     * @param $id
     *
     * @return Result
     */
    public function fetchById($id)
    {
        //$user = $this->getEntityManager()->find($this->getEntityClass(), $id);

        $query = $this->getEntityManager()->createQuery(
            'SELECT user FROM '.$this->getEntityClass().' user ' .
            'WHERE user.id = ?1 ' .
            'AND user.state != ?2'
        );
        $query->setParameter(1, $id);
        $query->setParameter(2, User::STATE_DISABLED);

        $users = $query->getResult();

        if (empty($users) || !isset($users[0])) {

            return new Result(null, Result::CODE_FAIL, 'User could not be found by id.');
        }

        $user = $users[0];

        // This is so we get a fresh user every time
        $this->getEntityManager()->refresh($user);

        return new Result($user);
    }

    /**
     * @param $username
     *
     * @return Result
     */
    public function fetchByUsername($username)
    {
        //$user = $this->getEntityManager()->getRepository($this->getEntityClass())->findOneBy(array('username' => $username));
        $query = $this->getEntityManager()->createQuery(
            'SELECT user FROM '.$this->getEntityClass().' user ' .
            'WHERE user.username = ?1 ' .
            'AND user.state != ?2'
        );
        $query->setParameter(1, $username);
        $query->setParameter(2, User::STATE_DISABLED);

        $users = $query->getResult();

        if (empty($users) || !isset($users[0])) {

            return new Result(null, Result::CODE_FAIL, 'User could not be found by username.');
        }

        $user = $users[0];

        // This is so we get a fresh user every time
        $this->getEntityManager()->refresh($user);

        return new Result($user);
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function create(User $user)
    {
        $result = $this->getValidInstance($user);

        $user = $result->getUser();

        // @todo if error, fail with null
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return new Result($user);
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function read(User $user)
    {
        $result = $this->getValidInstance($user);

        $user = $result->getUser();
        $id = $user->getId();
        if (!empty($id)) {

            $result = $this->fetchById($id);

            if($result->isSuccess()){

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
     * @param User $user
     *
     * @return Result
     */
    public function update(User $user)
    {
        $result = $this->getValidInstance($user);

        $user = $result->getUser();

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new Result(null, Result::CODE_FAIL, 'User cannot be updated, id required for update.');
        }

        // @todo if error, fail with null
        $this->getEntityManager()->merge($user);
        $this->getEntityManager()->flush();

        return new Result($user);
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function delete(User $user)
    {

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new Result(null, Result::CODE_FAIL, 'User cannot be deleted (disabled), id required for delete.');
        }

        $updateUser = new User();
        $updateUser->setId($user->getId());
        $updateUser->setState(User::STATE_DISABLED);

        $updateResult = $this->update($updateUser);

        if(!$updateResult->isSuccess()){

            return new Result(null, Result::CODE_FAIL, 'User cannot be deleted (disabled). ' . $updateResult->getMessage());
        }

        return new Result($user, Result::CODE_SUCCESS, 'User deleted (disabled) successfully.');
        /* by default, we should not support true delete
        $result = $this->getValidInstance($user);

        $user = $result->getUser();

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new Result(null, Result::CODE_FAIL, 'User cannot be deleted, id required for delete.');
        }

        //  if error, fail with null
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();

        return new Result($user);
        */
    }

    /**
     * @param User $user
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
     * @param User $user
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
} 