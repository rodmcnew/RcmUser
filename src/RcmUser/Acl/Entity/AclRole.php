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
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $parentId;
    /**
     * @var string
     */
    protected $roleIdentity;
    /**
     * @var string
     */
    protected $description;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

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

            $this->setId($data->getId());
            $this->setParentId($data->getParentId());
            $this->setRoleIdentity($data->getRoleIdentity());
            $this->setDescription($data->getDescription());

            return;
        }

        if (is_array($data)) {

            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
            if (isset($data['parentId'])) {
                $this->setParentId($data['parentId']);
            }
            if (isset($data['roleIdentity'])) {
                $this->setRoleIdentity($data['roleIdentity']);
            }
            if (isset($data['description'])) {
                $this->setDescription($data['description']);
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
        $obj->id = $this->getId();
        $obj->parentId = $this->getUsername();
        $obj->roleIdentity = $this->getRoleIdentity();
        $obj->description = $this->getDescription();

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