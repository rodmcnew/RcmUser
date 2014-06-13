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


use RcmUser\Result;
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
        $result = $this->getAclRoleDataMapper()->fetchDefaultGuestRoleIds();

        return $result;
    }

    /**
     * getDefaultUserRoleIds
     *
     * @return Result
     */
    public function getDefaultUserRoleIds()
    {
        $result = $this->getAclRoleDataMapper()->fetchDefaultUserRoleIds();

        return $result;
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
    public function getAllUserRoles()
    {

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
        $inArray = in_array($guestRoleId, $roles);

        /**
         * If we have the guest role and only the guest role;
         */
        if ($inArray && (count($roles) < 2)) {

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

        if (in_array($superAdminRoleId, $roles)) {

            return true;
        }

        return false;
    }

    /**
     * isDefaultGuestRole
     *
     * @param array $roleId role id
     *
     * @return bool
     */
    public function isDefaultGuestRole($roleId)
    {
        $defaultGuestRoles = $this->getDefaultUserRoleIds()->getData();

        if (in_array($roleId, $defaultGuestRoles)) {

            return true;
        }

        return true;
    }

    /**
     * isDefaultGuestRoles
     *
     * @param array $roleIds role ids
     *
     * @return bool
     */
    public function isDefaultGuestRoles($roleIds)
    {
        $defaultGuestRoles = $this->getDefaultUserRoleIds()->getData();

        foreach($defaultGuestRoles as $roleId){

            if(!in_array($roleId, $roleIds)){

                return false;
            }
        }

        return true;
    }

    /**
     * isDefaultUserRole
     *
     * @param array $roleId role id
     *
     * @return bool
     */
    public function isDefaultUserRole($roleId)
    {
        $defaultUserRoles = $this->getDefaultUserRoleIds()->getData();

        return in_array($roleId, $defaultUserRoles);
    }

    /**
     * isDefaultUserRoles
     *
     * @param array $roleIds role ids
     *
     * @return bool
     */
    public function isDefaultUserRoles($roleIds)
    {
        $defaultUserRoles = $this->getDefaultUserRoleIds()->getData();

        foreach($defaultUserRoles as $roleId){

            if(!in_array($roleId, $roleIds)){

                return false;
            }
        }

        return true;
    }

    /**
     * canAdd role
     *
     * @param User   $user
     * @param string $aclRoleId
     *
     * @return bool
     */
    public function canAddRole(User $user, $aclRoleId)
    {
        if ($this->isDefaultUserRole($aclRoleId)) {

            return false;
        }

        return true;
    }

    /**
     * validateAddRoles
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function validateAddRoles(User $user, $roles)
    {
        $result = new Result(
            null,
            Result::CODE_SUCCESS
        );

        foreach($roles as $key => $roleId){

            $can = $this->canAddRole($user, $roleId);
            if (!$can) {

                $result->setCode(Result::CODE_FAIL);
                $result->setMessage(
                    "Role ({$roleId}) is retricted and cannot be added."
                );

                unset($roles[$key]);
            }
        }

        $result->setData($roles);

        return $result;
    }

    /**
     * canRemove role
     *
     * @param User   $user   user
     * @param string $roleId roleId
     *
     * @return bool
     */
    public function canRemoveRole(User $user, $roleId)
    {
        return true;
    }

    /**
     * validateRemoveRoles
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function validateRemoveRoles(User $user, $roles)
    {
        $result = new Result(
            null,
            Result::CODE_SUCCESS
        );

        foreach($roles as $key => $roleId){

            $can = $this->canRemoveRole($user, $roleId);
            if (!$can) {

                $result->setCode(Result::CODE_FAIL);
                $result->setMessage(
                    "Role ({$roleId}) is retricted and cannot be removed."
                );

                unset($roles[$key]);
            }
        }

        $result->setData($roles);

        return $result;
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
        if (!$this->canAddRole($user, $roleId)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                "Role ({$roleId}) is set via logic and cannot be added."
            );
        }

        return $this->getUserRolesDataMapper()->add($user, $roleId);
    }

    /**
     * removeRole
     *
     * @param User   $user   user
     * @param string $roleId aclRoleId
     *
     * @return Result
     */
    public function removeRole(User $user, $roleId)
    {
        if (!$this->canRemoveRole($user, $roleId)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                "Role ({$roleId}) is set via logic and cannot be removed."
            );
        }

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

        $result = $this->validateAddRoles($user, $roles);

        if(!$result->isSuccess()){

            return $result;
        }

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
        $result = $this->validateAddRoles($user, $roles);

        if(!$result->isSuccess()){

            return $result;
        }

        return $this->getUserRolesDataMapper()->update($user, $roles);
    }

    /**
     * deleteRoles
     *
     * @param User $user user
     * @param array $roles roles
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function deleteRoles(User $user, $roles = array())
    {
        $result = $this->validateRemoveRoles($user, $roles);

        if(!$result->isSuccess()){

            return $result;
        }

        return $this->getUserRolesDataMapper()->delete($user);
    }

    /**
     * buildUserRoleProperty
     *
     * @param array $roles roles
     *
     * @return UserRoleProperty
     */
    public function buildUserRoleProperty(
        $roles = array()
    ) {
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
    public function buildValidUserRoleProperty(
        User $user,
        $roles = array()
    ) {

        $roles = $this->buildValidRoles(
            $user,
            $roles
        );

        return $this->buildUserRoleProperty(
            $roles
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
    public function buildValidRoles(
        User $user,
        $roles = array()
    ) {
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