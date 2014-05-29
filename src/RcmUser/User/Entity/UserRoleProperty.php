<?php
/**
 * UserRoleProperty.php
 *
 * UserRoleProperty
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Entity;

use RcmUser\User\Service\UserRolePropertyService;


/**
 * Class UserRoleProperty
 *
 * UserRoleProperty
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserRoleProperty
{
    /**
     * @var string
     */
    const PROPERTY_KEY = 'RcmUser\Acl\UserRoles';
    /**
     * @var array $roles
     */
    protected $roles = array();

    /**
     * @var UserRolePropertyService $userRolePropertyService
     */
    protected $userRolePropertyService;

    /**
     * @param array $roles
     * @param UserRolePropertyService $userRolePropertyService
     */
    public function __construct(
        UserRolePropertyService $userRolePropertyService,
        $roles = array()
    ) {
        $this->userRolePropertyService = $userRolePropertyService;
        $this->roles = $roles;
    }

    /**
     * getUserRolePropertyService
     *
     * @return UserRolePropertyService
     */
    public function getUserRolePropertyService()
    {
        return $this->userRolePropertyService;
    }


    /**
     * getRoles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * getRole
     *
     * @param string $roleId  roleId
     * @param mixed  $default default
     *
     * @return null
     */
    public function getRole($roleId, $default = null)
    {
        $key = array_search($roleId, $this->roles);

        if(!$key){
            return $default;
        }

        return $this->roles[$key];
    }

    /**
     * hasRole
     *
     * @param string $roleId role
     *
     * @return bool
     */
    public function hasRole($roleId)
    {
        if ($this->getRole($roleId)) {

            return true;
        }

        return false;
    }

    /**
     * isGuest
     *
     * @return bool
     */
    public function isGuest()
    {
        return $this->userRolePropertyService->isGuest($this->roles);
    }

    /**
     * isSuperAdmin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return  $this->userRolePropertyService->isSuperAdmin($this->roles);
    }
} 