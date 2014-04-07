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

class AbstractUserDataMapper implements UserDataMapperInterface
{
    /**
     * @param $id
     *
     * @return Result
     */
    public function fetchById($id)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be found by id.');
    }

    /**
     * @param $username
     *
     * @return Result
     */
    public function fetchByUsername($username)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be found by username.');
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function create(UserInterface $user)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be created.');
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function read(UserInterface $user)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be read.');
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function update(UserInterface $user)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be updated.');
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function delete(UserInterface $user)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be deleted.');
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