<?php
/**
 * BjyIdentityProvider.php
 *
 * BjyIdentityProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Identity\ProviderInterface;
use RcmUser\Service\RcmUserService;

/**
 * BjyIdentityProvider
 *
 * BjyIdentityProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class BjyIdentityProvider implements ProviderInterface
{
    /**
     * @var
     */
    protected $userService;

    /**
     * @var array
     */
    protected $DefaultRoleIdentities = array('guest');

    /**
     * setUserService
     *
     * @param RcmUserService $userService userService
     *
     * @return void
     */
    public function setUserService(RcmUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * getUserService
     *
     * @return RcmUserService
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * setDefaultRoleIdentities
     *
     * @param array $defaultRoleIdentities defaultRoleIdentities
     *
     * @return void
     */
    public function setDefaultRoleIdentities($defaultRoleIdentities)
    {
        $this->defaultRoleIdentities = $defaultRoleIdentities;
    }

    /**
     * getDefaultRoleIdentities
     *
     * @return array
     */
    public function getDefaultRoleIdentities()
    {
        return $this->defaultRoleIdentities;
    }

    /**
     * getIdentity
     * Roles Retrieve roles for the current identity
     *
     * @return mixed|null|\string[]|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getIdentityRoles()
    {

        $userRoles = $this->getUserService()->getCurrentUserProperty(
            'RcmUser\Acl\UserRoles', $this->getDefaultRoleIdentities(), false
        );

        return $userRoles;
    }
}
