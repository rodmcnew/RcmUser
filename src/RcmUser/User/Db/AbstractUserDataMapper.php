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

class AbstractUserDataMapper implements UserDataMapperInterface
{
    /**
     * @param       $id
     * @param array $params
     *
     * @return mixed|Result
     */
    public function fetchById($id, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be found by id.');
    }

    /**
     * @param       $username
     * @param array $params
     *
     * @return mixed|Result
     */
    public function fetchByUsername($username, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be found by username.');
    }

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed|Result
     */
    public function create(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be created.');
    }

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed|Result
     */
    public function read(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be read.');
    }

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed|Result
     */
    public function update(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be updated.');
    }

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed|Result
     */
    public function delete(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be deleted.');
    }

    /**
     * @param User  $user
     * @param array $params
     *
     * @return bool
     */
    public function canUpdate(User $user, $params = array())
    {

        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        return true;
    }

    protected function parseParamValue($key, $params = array()){

        if(isset($params[$key])){

            return $params[$key];
        }

        return null;
    }
} 