<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\User\Entity;


use RcmUser\Model\Properties\Entity\AbstractProperty;

/**
 * Class UserAccess
 *
 * @package RcmUser\Model\User\Entity
 */
class UserAccess extends AbstractProperty
{

    /**
     * @var int|bool
     */
    protected $active = 0;
    /**
     * @var array
     */
    protected $roles = array();

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $active = (int) $active;
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        if(!is_array($roles)) {

            // @todo throw error
            return false;
        }

        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $role = (string) $role;
        $this->roles[$role] = $role;
    }

    /**
     * @return mixed
     */
    public function getRole($role)
    {
        if (isset($this->roles[$role])) {

            return $this->roles[$role];
        }

        return null;
    }
} 