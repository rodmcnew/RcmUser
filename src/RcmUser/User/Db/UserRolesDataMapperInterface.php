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


use RcmUser\Acl\Entity\AclRole;
use RcmUser\User\Entity\User;

/**
 * Interface UserRolesDataMapperInterface
 *
 * @package RcmUser\User\Db
 */
interface UserRolesDataMapperInterface {

    /**
     * @param User $user
     * @param AclRole          $role
     *
     * @return mixed
     */
    public function add(User $user, AclRole $role);

    /**
     * @param User $user
     * @param AclRole          $role
     *
     * @return mixed
     */
    public function remove(User $user, AclRole $role);

    /**
     * @param User $user
     * @param array         $roles
     *
     * @return mixed
     */
    public function create(User $user, $roles = array());

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function read(User $user);

    /**
     * @param User $user
     * @param array         $roles
     *
     * @return mixed
     */
    public function update(User $user, $roles = array());

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user);
} 