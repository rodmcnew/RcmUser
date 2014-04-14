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
     * @param $id
     *
     * @return RcmUser\User\Result
     */
    public function fetchById($id);

    /**
     * @param $username
     *
     * @return RcmUser\User\Result
     */
    public function fetchByUsername($username);

    /**
     * @param User $user
     *
     * @return RcmUser\User\Result
     */
    public function create(User $user);

    /**
     * This will read the user from Id or Username. Id will get priority if it is set.
     * @param User $user
     *
     * @return RcmUser\User\Result
     */
    public function read(User $user);

    /**
     * @param User $user
     *
     * @return RcmUser\User\Result
     */
    public function update(User $user);

    /**
     * @param User $user
     *
     * @return RcmUser\User\Result
     */
    public function delete(User $user);

    /**
     * @param User $user
     *
     * @return RcmUser\User\Result
     */
    //public function disable(User $user);

} 