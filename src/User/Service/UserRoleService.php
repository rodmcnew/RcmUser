<?php

namespace RcmUser\User\Service;

use RcmUser\Event\EventProvider;
use RcmUser\Result;
use RcmUser\User\Db\UserRolesDataMapperInterface;
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;
use Zend\EventManager\EventManagerInterface;

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
class UserRoleService extends EventProvider
{
    const EVENT_IDENTIFIER = UserRoleService::class;

    const EVENT_ADD_USER_ROLE = 'addUserRole';
    const EVENT_ADD_USER_ROLE_FAIL = 'addUserRoleFail';
    const EVENT_ADD_USER_ROLE_SUCCESS = 'addUserRoleSuccess';

    const EVENT_REMOVE_USER_ROLE = 'removeUserRole';
    const EVENT_REMOVE_USER_ROLE_FAIL = 'removeUserRoleFail';
    const EVENT_REMOVE_USER_ROLE_SUCCESS = 'removeUserRoleSuccess';

    const EVENT_CREATE_USER_ROLES = 'createUserRoles';
    const EVENT_CREATE_USER_ROLES_FAIL = 'createUserRolesFail';
    const EVENT_CREATE_USER_ROLES_SUCCESS = 'createUserRolesSuccess';

    const EVENT_UPDATE_USER_ROLES = 'updateUserRoles';
    const EVENT_UPDATE_USER_ROLES_FAIL = 'updateUserRolesFail';
    const EVENT_UPDATE_USER_ROLES_SUCCESS = 'updateUserRolesSuccess';

    const EVENT_DELETE_USER_ROLES = 'deleteUserRoles';
    const EVENT_DELETE_USER_ROLES_FAIL = 'deleteUserRolesFail';
    const EVENT_DELETE_USER_ROLES_SUCCESS = 'deleteUserRolesSuccess';

    /**
     * @var UserRolesDataMapperInterface
     */
    protected $userRolesDataMapper;

    /**
     * Constructor.
     *
     * @param UserRolesDataMapperInterface $userRolesDataMapper
     * @param EventManagerInterface        $eventManager
     */
    public function __construct(
        UserRolesDataMapperInterface $userRolesDataMapper,
        EventManagerInterface $eventManager
    ) {
        $this->userRolesDataMapper = $userRolesDataMapper;
        parent::__construct($eventManager);
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
        $inArray = in_array(
            $guestRoleId,
            $roles
        );

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

        if (in_array(
            $superAdminRoleId,
            $roles
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * getSavableRoles
     *
     * @param array $roles roles
     *
     * @return array
     */
    public function parseSavableRoles($roles = [])
    {
        $defaultRolesResult = $this->getDefaultUserRoleIds();

        $defaultRoles = $defaultRolesResult->getData();

        return array_diff(
            $roles,
            $defaultRoles
        );
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

        if (in_array(
            $roleId,
            $defaultGuestRoles
        )
        ) {
            return true;
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

        return in_array(
            $roleId,
            $defaultUserRoles
        );
    }

    /**
     * canAdd role
     *
     * @param User   $user      User to add role to
     * @param string $aclRoleId Role Id
     *
     * @return bool
     */
    public function canAddRole(
        User $user,
        $aclRoleId
    ) {
        if ($this->isDefaultUserRole($aclRoleId)) {
            return false;
        }

        return true;
    }

    /**
     * canRemove role
     *
     * @param User   $user   user
     * @param string $roleId roleId
     *
     * @return bool
     */
    public function canRemoveRole(
        User $user,
        $roleId
    ) {
        return true;
    }

    /**
     * addRole
     *
     * @param User   $user   user
     * @param string $roleId aclRoleId
     *
     * @return Result
     */
    public function addRole(
        User $user,
        $roleId
    ) {
        $this->getEventManager()->trigger(
            self::EVENT_ADD_USER_ROLE,
            $this,
            [
                'user' => $user,
                'roleId' => $roleId
            ]
        );

        if (!$this->canAddRole(
            $user,
            $roleId
        )
        ) {
            $result = new Result(
                null,
                Result::CODE_FAIL,
                "Role ({$roleId}) is set via logic and cannot be added."
            );

            $this->getEventManager()->trigger(
                self::EVENT_ADD_USER_ROLE_FAIL,
                $this,
                [
                    'user' => $user,
                    'roleId' => $roleId,
                    'result' => $result,
                ]
            );

            return $result;
        }

        $result = $this->getUserRolesDataMapper()->add(
            $user,
            $roleId
        );

        if (!$result->isSuccess()) {
            $this->getEventManager()->trigger(
                self::EVENT_ADD_USER_ROLE_FAIL,
                $this,
                [
                    'user' => $user,
                    'roleId' => $roleId,
                    'result' => $result,
                ]
            );

            return $result;
        }

        $this->getEventManager()->trigger(
            self::EVENT_ADD_USER_ROLE_SUCCESS,
            $this,
            [
                'user' => $user,
                'roleId' => $roleId,
                'result' => $result,
            ]
        );

        return $result;
    }

    /**
     * removeRole
     *
     * @param User   $user   user
     * @param string $roleId aclRoleId
     *
     * @return Result
     */
    public function removeRole(
        User $user,
        $roleId
    ) {
        $this->getEventManager()->trigger(
            self::EVENT_REMOVE_USER_ROLE,
            $this,
            [
                'user' => $user,
                'roleId' => $roleId
            ]
        );

        if (!$this->canRemoveRole(
            $user,
            $roleId
        )
        ) {
            $result = new Result(
                null,
                Result::CODE_FAIL,
                "Role ({$roleId}) is set via logic and cannot be removed."
            );

            $this->getEventManager()->trigger(
                self::EVENT_REMOVE_USER_ROLE_FAIL,
                $this,
                [
                    'user' => $user,
                    'roleId' => $roleId,
                    'result' => $result,
                ]
            );

            return $result;
        }

        $result = $this->getUserRolesDataMapper()->remove(
            $user,
            $roleId
        );

        if (!$result->isSuccess()) {
            $this->getEventManager()->trigger(
                self::EVENT_REMOVE_USER_ROLE_FAIL,
                $this,
                [
                    'user' => $user,
                    'roleId' => $roleId,
                    'result' => $result,
                ]
            );

            return $result;
        }

        $this->getEventManager()->trigger(
            self::EVENT_REMOVE_USER_ROLE_SUCCESS,
            $this,
            [
                'user' => $user,
                'roleId' => $roleId,
                'result' => $result,
            ]
        );

        return $result;
    }

    /**
     * createRoles
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function createRoles(
        User $user,
        $roles = []
    ) {
        $this->getEventManager()->trigger(
            self::EVENT_CREATE_USER_ROLES,
            $this,
            [
                'user' => $user,
                'roles' => $roles
            ]
        );

        $roles = $this->parseSavableRoles($roles);

        $result = $this->getUserRolesDataMapper()->create(
            $user,
            $roles
        );

        if (!$result->isSuccess()) {
            $this->getEventManager()->trigger(
                self::EVENT_CREATE_USER_ROLES_FAIL,
                $this,
                [
                    'user' => $user,
                    'roles' => $roles,
                    'result' => $result
                ]
            );

            return $result;
        }

        $this->getEventManager()->trigger(
            self::EVENT_CREATE_USER_ROLES_SUCCESS,
            $this,
            [
                'user' => $user,
                'roles' => $roles,
                'result' => $result
            ]
        );

        return $result;
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
    public function updateRoles(
        User $user,
        $roles = []
    ) {
        $this->getEventManager()->trigger(
            self::EVENT_UPDATE_USER_ROLES,
            $this,
            [
                'user' => $user,
                'roles' => $roles
            ]
        );

        $roles = $this->parseSavableRoles($roles);

        $result = $this->getUserRolesDataMapper()->update(
            $user,
            $roles
        );

        if (!$result->isSuccess()) {
            $this->getEventManager()->trigger(
                self::EVENT_UPDATE_USER_ROLES_FAIL,
                $this,
                [
                    'user' => $user,
                    'roles' => $roles,
                    'result' => $result
                ]
            );

            return $result;
        }

        $this->getEventManager()->trigger(
            self::EVENT_UPDATE_USER_ROLES_SUCCESS,
            $this,
            [
                'user' => $user,
                'roles' => $roles,
                'result' => $result
            ]
        );

        return $result;
    }

    /**
     * deleteRoles
     *
     * @param User  $user  user
     * @param array $roles array of Role Ids
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function deleteRoles(
        User $user,
        $roles = []
    ) {
        $this->getEventManager()->trigger(
            self::EVENT_DELETE_USER_ROLES,
            $this,
            [
                'user' => $user,
                'roles' => $roles
            ]
        );
        $roles = $this->parseSavableRoles($roles);

        $result = $this->getUserRolesDataMapper()->delete(
            $user,
            $roles
        );

        if (!$result->isSuccess()) {
            $this->getEventManager()->trigger(
                self::EVENT_DELETE_USER_ROLES_FAIL,
                $this,
                [
                    'user' => $user,
                    'roles' => $roles,
                    'result' => $result
                ]
            );

            return $result;
        }

        $this->getEventManager()->trigger(
            self::EVENT_DELETE_USER_ROLES_SUCCESS,
            $this,
            [
                'user' => $user,
                'roles' => $roles,
                'result' => $result
            ]
        );

        return $result;
    }

    /**
     * buildUserRoleProperty
     *
     * @param array $roles roles
     *
     * @return UserRoleProperty
     */
    public function buildUserRoleProperty(
        $roles = []
    ) {
        return new UserRoleProperty($roles);
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
        $roles = []
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
        $roles = []
    ) {
        if (!empty($roles)) {
            return $roles;
        }

        $id = $user->getId();
        if (empty($id)) {
            $roles = $this->getDefaultGuestRoleIds()->getData();
        } else {
            $roles = $this->getDefaultUserRoleIds()->getData();
        }

        return $roles;
    }
}
