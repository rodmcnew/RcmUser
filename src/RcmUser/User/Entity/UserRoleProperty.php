<?php
/**
 * UserRoleProperty.php
 *
 * LongDescHere
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
 * LongDescHere
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
        $this->guestRoleId = $guestRoleId;
        $this->superAdminRoleId = $superAdminRoleId;
    }

    /**
     * setRoles
     *
     * @param $roles
     *
     * @return void
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
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
     * setRoleId
     *
     * @param $roleId
     *
     * @return void
     */
    public function setRoleId($roleId)
    {
        if (!in_array($roleId, $this->roles)) {

            $this->roles[] = $roleId;
        }
    }

    /**
     * getRoleId
     *
     * @param $roleId
     *
     * @return null
     */
    public function getRoleId($roleId)
    {
        $key = array_search($roleId, $this->roles);

        if(!$key){
            return null;
        }

        return $this->roles[$key];
    }

    /**
     * hasRoleId
     *
     * @param string $roleId role
     *
     * @return bool
     */
    public function hasRoleId($roleId)
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
     * isGuest
     *
     * @return bool
     */
    public function isSupperAdmin()
    {
        if ($this->getRole($this->superAdminRoleId )) {

            return true;
        }

        return false;
    }
} 