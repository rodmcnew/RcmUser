<?php
 /**
 * UserRolesDataMapper.php
 *
 * LongDescHere
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

use RcmUser\Acl\Entity\AclRole;
use RcmUser\Exception\RcmUserException;
use RcmUser\User\Entity\User;


/**
 * Class UserRolesDataMapper
 *
 * LongDescHere
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

class UserRolesDataMapper implements UserRolesDataMapperInterface
{
    /**
     * @var string
     */
    const PROPERTY_KEY = 'RcmUser\Acl\UserRoles';

    /**
     * @var array
     */
    protected $defaultRoleIdentities = array();
    /**
     * @var array
     */
    protected $defaultAuthenticatedRoleIdentities = array();

    /**
     * @param array $defaultAuthenticatedRoleIdentities
     */
    public function setDefaultAuthenticatedRoleIdentities(
        $defaultAuthenticatedRoleIdentities
    ) {
        $this->defaultAuthenticatedRoleIdentities
            = $defaultAuthenticatedRoleIdentities;
    }

    /**
     * @return array
     */
    public function getDefaultAuthenticatedRoleIdentities()
    {
        return $this->defaultAuthenticatedRoleIdentities;
    }

    /**
     * @param array $defaultRoleIdentities
     */
    public function setDefaultRoleIdentities($defaultRoleIdentities)
    {
        $this->defaultRoleIdentities = $defaultRoleIdentities;
    }

    /**
     * @return array
     */
    public function getDefaultRoleIdentities()
    {
        return $this->defaultRoleIdentities;
    }

    /**
     * add
     *
     * @param User    $user      user
     * @param AclRole $aclRoleId aclRoleId
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function add(User $user, $aclRoleId)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * remove
     *
     * @param User    $user      user
     * @param AclRole $aclRoleId aclRoleId
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function remove(User $user, $aclRoleId)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * create
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function create(User $user, $roles = array())
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * read
     *
     * @param User $user user
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function read(User $user)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * update
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function update(User $user, $roles = array())
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * delete
     *
     * @param User $user user
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function delete(User $user)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }
} 