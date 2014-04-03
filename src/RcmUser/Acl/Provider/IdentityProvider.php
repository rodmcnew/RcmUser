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
class IdentityProvider implements ProviderInterface
{
    protected $userService;

    protected $defaultRoleIdentity = 'guest';

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
     * @param mixed $defaultRoleIdentity
     */
    public function setDefaultRoleIdentity($defaultRoleIdentity)
    {
        $this->defaultRoleIdentity = $defaultRoleIdentity;
    }

    /**
     * @return mixed
     */
    public function getDefaultRoleIdentity()
    {
        return $this->defaultRoleIdentity;
    }

    /**
     * Retrieve roles for the current identity
     *
     * @return string[]|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getIdentityRoles(){

        $userRoles = $this->getUserService()->getCurrentUserProperty('RcmUser\Acl\UserRoles', array($this->getDefaultRoleIdentity()), false);

        return $userRoles;
    }
}
