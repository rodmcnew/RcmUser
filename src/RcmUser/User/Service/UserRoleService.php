<?php
/**
 * UserRoleService.php
 *
 * UserRoleService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Service;


use RcmUser\User\Db\UserRolesDataMapperInterface;
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;

/**
 * Class UserRoleService
 *
 * UserRoleService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserRoleService
{
    /**
     * @var UserRolesDataMapperInterface
     */
    protected $userRolesDataMapper;

    /**
     * __construct
     *
     * @param UserRolesDataMapperInterface $userRolesDataMapper
     */
    public function __construct(
        UserRolesDataMapperInterface $userRolesDataMapper
    ) {

        $this->userRolesDataMapper = $userRolesDataMapper;
    }

    /**
     * getUserRolesDataMapper
     *
     * @return UserRolesDataMapperInterface
     */
    protected function getUserRolesDataMapper()
    {
        return $this->userRolesDataMapper;
    }

    /**
     * getAclRoleDataMapper
     *
     * @return \RcmUser\Acl\Db\AclRoleDataMapperInterface
     */
    protected function getAclRoleDataMapper()
    {
        return $this->userRolesDataMapper->getAclRoleDataMapper();
    }

    /**
     * getDefaultGuestRoleIds
     *
     * @return Result
     */
    public function getDefaultGuestRoleIds()
    {
        return $this->getAclRoleDataMapper()->fetchDefaultGuestRoleIds();
    }

    /**
     * getDefaultUserRoleIds
     *
     * @return Result
     */
    public function getDefaultUserRoleIds()
    {
        return $this->getAclRoleDataMapper()->fetchDefaultUserRoleIds();
    }

    /**
     * getGuestRoleId
     *
     * @return Result
     */
    public function getGuestRoleId()
    {
        return $this->getAclRoleDataMapper()->fetchGuestRoleId();
    }

    /**
     * getSuperAdminRoleId
     *
     * @return Result
     */
    public function getSuperAdminRoleId()
    {
        return $this->getAclRoleDataMapper()->fetchSuperAdminRoleId();
    }

    /**
     * getAllUserRoles
     *
     * @return Result
     */
    public function getAllUserRoles(){

        return $this->getUserRolesDataMapper()->fetchAll();
    }

    /**
     * isGuest
     *
     * @param array $roles roles
     *
     * @return bool
     */
    public function isGuest($roles)
    {
        $guestRoleId = $this->getGuestRoleId()->getData();
        $key = array_search($guestRoleId, $roles);

        /**
         * If we have the guest role and only the guest role;
         */
        if ($key !== false && (count($roles) < 2)) {

            return true;
        }

        return false;
    }

    /**
     * isSuperAdmin
     *
     * @param array $roles roles
     *
     * @return bool
     */
    public function isSuperAdmin($roles)
    {
        $superAdminRoleId = $this->getSuperAdminRoleId()->getData();
        $key = array_search($superAdminRoleId, $roles);

        if ($key !== false) {

            return true;
        }

        return false;
    }

    /**
     * isDefaultRoles
     *
     * @param array $roles roles
     *
     * @return bool
     */
    public function isDefaultRoles($roles)
    {
        if($roles == $this->getDefaultGuestRoleIds()->getData()){

            return true;
        }

        if($roles == $this->getDefaultUserRoleIds()->getData()){

            return true;
        }

        return true;
    }

    /**
     * addRole
     *
     * @param User   $user   user
     * @param string $roleId aclRoleId
     *
     * @return \RcmUser\User\Db\Result
     */
    public function addRole(User $user, $roleId)
    {
        return $this->getUserRolesDataMapper()->add($user, $roleId);
    }

    /**
     * removeRole
     *
     * @param User    $user   user
     * @param string  $roleId aclRoleId
     *
     * @return Result
     */
    public function removeRole(User $user, $roleId)
    {
        return $this->getUserRolesDataMapper()->remove($user, $roleId);
    }

    /**
     * createRoles
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function createRoles(User $user, $roles = array())
    {
        return $this->getUserRolesDataMapper()->create($user, $roles);
    }

    /**
     * readRoles
     *
     * @param User $user user
     *
     * @return Result
     */
    public function readRoles(User $user)
    {
        return $this->getUserRolesDataMapper()->read($user);
    }

    /**
     * updateRoles
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function updateRoles(User $user, $roles = array())
    {
        return $this->getUserRolesDataMapper()->update($user, $roles);
    }

    /**
     * deleteRoles
     *
     * @param User $user user
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function deleteRoles(User $user)
    {
        return $this->getUserRolesDataMapper()->delete($user);
    }

    /**
     * buildUserRoleProperty
     *
     * @param array $roles roles
     *
     * @return UserRoleProperty
     */
    public function buildUserRoleProperty($roles = array())
    {
        return new UserRoleProperty(
            $roles
        );
    }

    /**
     * buildValidUserRoleProperty
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return UserRoleProperty
     */
    public function buildValidUserRoleProperty(User $user, $roles = array()){

        return $this->buildUserRoleProperty(
            $this->buildValidRoles($user, $roles)
        );
    }

    /**
     * buildValidRoles
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return array
     */
    public function buildValidRoles(User $user, $roles = array())
    {
        if (!empty($roles)) {

            return $roles;
        }

        if (empty($user->getId())) {

            $roles = $this->getDefaultGuestRoleIds()->getData();
        } else {

            $roles = $this->getDefaultUserRoleIds()->getData();
        }

        return $roles;
    }
} 