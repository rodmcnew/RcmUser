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
use RcmUser\User\Entity\UserInterface;

/**
 * Interface UserRolesDataMapperInterface
 *
 * @package RcmUser\User\Db
 */
interface UserRolesDataMapperInterface {

    /**
     * @param UserInterface $user
     * @param AclRole          $role
     *
     * @return mixed
     */
    public function add(UserInterface $user, AclRole $role);

    /**
     * @param UserInterface $user
     * @param AclRole          $role
     *
     * @return mixed
     */
    public function remove(UserInterface $user, AclRole $role);

    /**
     * @param UserInterface $user
     * @param array         $roles
     *
     * @return mixed
     */
    public function create(UserInterface $user, $roles = array());

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function read(UserInterface $user);

    /**
     * @param UserInterface $user
     * @param array         $roles
     *
     * @return mixed
     */
    public function update(UserInterface $user, $roles = array());

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function delete(UserInterface $user);
} 