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
use RcmUser\User\Entity\UserInterface;
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
        $user = $this->getEntityManager()->find($this->getEntityClass(), $id);
        if (empty($user)) {

            return new Result(null, Result::CODE_FAIL, 'User could not be found by id.');
        }

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
        $user = $this->getEntityManager()->getRepository($this->getEntityClass())->findOneBy(array('username' => $username));
        if (empty($user)) {

            return new Result(null, Result::CODE_FAIL, 'User could not be found by username.');
        }

        // This is so we get a fresh user every time
        $this->getEntityManager()->refresh($user);

        return new Result($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function create(UserInterface $user)
    {
        $result = $this->getValidInstance($user);

        $user = $result->getUser();

        // @todo if error, fail with null
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return new Result($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function read(UserInterface $user)
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

        return new Result(null, Result::CODE_FAIL, 'User could not be read.');
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function update(UserInterface $user)
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
     * @param UserInterface $user
     *
     * @return Result
     */
    public function delete(UserInterface $user)
    {

        return new Result(null, Result::CODE_FAIL, 'User cannot be deleted, delete not supported.');
        /* by default, we should not support delete
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
     * @param UserInterface $user
     *
     * @return Result
     */
    public function getValidInstance(UserInterface $user)
    {

        if (!($user instanceof DoctrineUser)) {

            $doctrineUser = new DoctrineUser();
            $doctrineUser->populate($user);

            $user = $doctrineUser;
        }

        return new Result($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function canUpdate(UserInterface $user)
    {

        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        return true;
    }
} 