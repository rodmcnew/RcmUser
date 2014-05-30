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

use RcmUser\User\Service\UserRoleService;


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
     * @param array $roles
     */
    public function __construct(
        $roles = array()
    ) {
        $this->roles = $this->setRoles($roles);
    }

    /**
     * setRoles
     *
     * @param array $roles roles
     *
     * @return array
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
     * setRole
     *
     * @param string $roleId roleId
     *
     * @return void
     */
    public function setRole($roleId)
    {
        if(!$this->hasRole($roleId)){

            $this->roles[] = $roleId;
        }
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
        if ($this->getRole($roleId, false)) {

            return true;
        }

        return false;
    }

} 