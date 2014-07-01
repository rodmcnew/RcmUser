<?php
/**
 * UserRolesDataMapperInterface.php
 *
 * UserRolesDataMapperInterface
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


use RcmUser\User\Entity\User;

/**
 * Interface UserRolesDataMapperInterface
 *
 * UserRolesDataMapperInterface
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
interface UserRolesDataMapperInterface
{

    /**
     * getAvailableRoles
     *
     * @return array
     */
    public function getAvailableRoles();

    /**
     * fetchAll
     *
     * @param array $options options
     *
     * @return Result
     */
    public function fetchAll($options = array());

    /**
     * add
     *
     * @param User   $user      user
     * @param string $aclRoleId aclRoleId
     *
     * @return Result
     */
    public function add(User $user, $aclRoleId);

    /**
     * remove
     *
     * @param User   $user      user
     * @param string $aclRoleId aclRoleId
     *
     * @return Result
     */
    public function remove(User $user, $aclRoleId);

    /**
     * create
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function create(User $user, $roles = array());

    /**
     * read
     *
     * @param User $user user
     *
     * @return Result
     */
    public function read(User $user);

    /**
     * update
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function update(User $user, $roles = array());

    /**
     * delete
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function delete(User $user, $roles = array());
} 