<?php
/**
 * AclRole.php
 *
 * AclRole
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Entity;

use RcmUser\Exception\RcmUserException;
use Zend\Permissions\Acl\Role\RoleInterface;


/**
 * AclRole
 *
 * AclRole
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclRole implements RoleInterface, \JsonSerializable, \IteratorAggregate
{
    /**
     * @var string
     */
    protected $roleId;

    /**
     * @var string
     */
    protected $parentRoleId = null;

    /**
     * @var AclRole
     */
    protected $parentRole = null;

    /**
     * @var string
     */
    protected $description;

    /**
     * setRoleId
     *
     * @param string $roleId role identity
     *
     * @return void
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * getRoleId
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * setParentRoleId
     *
     * @param string|null $parentRoleId parent role
     *
     * @return void
     */
    public function setParentRoleId($parentRoleId)
    {
        $this->parentRoleId = $parentRoleId;
    }

    /**
     * getParentRoleId
     *
     * @return string|null
     */
    public function getParentRoleId()
    {
        return $this->parentRoleId;
    }

    /**
     * setParentRole
     *
     * @param AclRole $parentRole parentRole
     *
     * @return void
     */
    public function setParentRole(AclRole $parentRole)
    {
        $this->parentRole = $parentRole;
    }

    /**
     * getParentRole
     *
     * @return AclRole
     */
    public function getParentRole()
    {
        return $this->parentRole;
    }

    /**
     * getParent
     *
     * @return null|string|AclRole
     */
    public function getParent()
    {
        if(empty($this->parentRole)){

            return $this->getParentRoleId();
        }

        return $this->getParentRole();
    }

    /**
     * setDescription
     *
     * @param string $description description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * populate
     *
     * @param array|AclRole $data data to populate with
     *
     * @return void
     * @throws RcmUserException
     */
    public function populate($data = array())
    {
        if (($data instanceof AclRole)) {

            $this->setRoleId($data->getRoleId());
            $this->setDescription($data->getDescription());
            $this->setParentRoleId($data->getParentRoleId());

            return;
        }

        if (is_array($data)) {
            if (isset($data['roleId'])) {
                $this->setRoleId($data['roleId']);
            }
            if (isset($data['description'])) {
                $this->setDescription($data['description']);
            }
            if (isset($data['parentRoleId'])) {
                $this->setParentRoleId($data['parentRoleId']);
            }

            return;
        }

        throw new RcmUserException(
            'Role data could not be populated, data format not supported'
        );
    }

    /**
     * jsonSerialize
     *
     * @return \stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->roleId = $this->getRoleId();
        $obj->description = $this->getDescription();
        $obj->parentRoleId = $this->getParentRoleId();

        return $obj;
    }

    /**
     * getIterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {

        return new \ArrayIterator(get_object_vars($this));
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getRoleId();
    }
} 