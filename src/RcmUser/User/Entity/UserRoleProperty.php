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
    protected $roles = array();

    protected $guestRoleId = null;

    protected $superAdminRoleId = null;

    public function __construct(
        $roles = array(),
        $guestRoleId = null,
        $superAdminRoleId = null
    ) {
        $this->roles = $roles;
        $this->guestRoleId = $guestRoleId;
        $this->superAdminRoleId = $superAdminRoleId;
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
        if ($this->getRole($this->guestRoleId) && (count($this->roles) > 1)) {

            return true;
        }

        return false;
    }

    /**
     * isSuperAdmin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        if ($this->getRole($this->superAdminRoleId)) {

            return true;
        }

        return false;
    }
} 