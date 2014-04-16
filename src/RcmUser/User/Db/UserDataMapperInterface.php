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


use RcmUser\User\Entity\User;
use RcmUser\User\Result;

/**
 * Interface UserDataMapperInterface
 *
 * @package RcmUser\User
 */
interface UserDataMapperInterface
{
    const ID_FIELD = 'id';
    const USERNAME_FIELD = 'username';

    /**
     * @param       $id
     * @param array $params
     *
     * @return mixed
     */
    public function fetchById($id);

    /**
     * @param       $username
     * @param array $params
     *
     * @return mixed
     */
    public function fetchByUsername($username);

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed
     */
    public function create(User $user);

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed
     */
    public function read(User $user);

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed
     */
    public function update(User $user);

    /**
     * @param User  $user
     * @param array $params
     *
     * @return mixed
     */
    public function delete(User $user);
} 