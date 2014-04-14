<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Entity;

use Zend\Permissions\Acl\Role\RoleInterface;


/**
 * Class AclRole
 *
 * @package RcmUser\Acl\Entity
 */
class AclRole implements RoleInterface, \JsonSerializable, \IteratorAggregate
{
    /**
     * @var string
     */
    protected $roleIdentity;
    /**
     * @var string
     */
    protected $description;

    protected $parentRole = null;

    /**
     * @param string $roleIdentity
     */
    public function setRoleIdentity($roleIdentity)
    {
        $this->roleIdentity = $roleIdentity;
    }

    /**
     * @return string
     */
    public function getRoleIdentity()
    {
        return $this->roleIdentity;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param AclRole|null $parentRole
     */
    public function setParentRole($parentRole)
    {
        $this->parentRole = $parentRole;
    }

    /**
     * @return null
     */
    public function getParentRole()
    {
        return $this->parentRole;
    }

    /**
     * @return null
     */
    public function getParent()
    {
        return $this->getParentRole();
    }

    /**
     * @return string|void
     */
    public function getRoleId()
    {
        return $this->getRoleIdentity();
    }

    /**
     * @param array|AclRole $data
     *
     * @throws RcmUserException
     */
    public function populate($data = array())
    {
        if (($data instanceof AclRole)) {

            $this->setRoleIdentity($data->getRoleIdentity());
            $this->setDescription($data->getDescription());
            $this->setParentRole($data->getParentRole());

            return;
        }

        if (is_array($data)) {
            if (isset($data['roleIdentity'])) {
                $this->setRoleIdentity($data['roleIdentity']);
            }
            if (isset($data['description'])) {
                $this->setDescription($data['description']);
            }
            if (isset($data['parentRole'])) {
                $this->setRoleIdentity($data['parentRole']);
            }
            return;
        }

        throw new RcmUserException('Role data could not be populated, data format not supported');
    }

    /**
     * @return stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->roleIdentity = $this->getRoleIdentity();
        $obj->description = $this->getDescription();
        $obj->parentRole = $this->getParentRole();

        return $obj;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {

        return new \ArrayIterator(get_object_vars($this));
    }
} 