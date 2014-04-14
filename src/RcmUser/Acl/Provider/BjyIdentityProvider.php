<?php
/**
 *
 */

namespace  RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Identity\ProviderInterface;
use RcmUser\Service\RcmUserService;

/**
 *
 */
class BjyIdentityProvider implements ProviderInterface
{
    protected $userService;

    protected $DefaultRoleIdentities= array('guest');

    /**
     * @param RcmUserService $userService
     */
    public function setUserService(RcmUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return mixed
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @param array $DefaultRoleIdentities
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
     * Retrieve roles for the current identity
     *
     * @return string[]|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getIdentityRoles(){

        $userRoles = $this->getUserService()->getCurrentUserProperty('RcmUser\Acl\UserRoles', $this->getDefaultRoleIdentities(), false);

        return $userRoles;
    }
}
