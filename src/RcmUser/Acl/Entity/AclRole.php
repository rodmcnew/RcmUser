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
    protected $roleIdentity;
    /**
     * @var string
     */
    protected $description;

    /**
     * @var null
     */
    protected $parentRole = null;

    /**
     * setRoleIdentity
     *
     * @param string $roleIdentity role identity
     *
     * @return void
     */
    public function setRoleIdentity($roleIdentity)
    {
        $this->roleIdentity = $roleIdentity;
    }

    /**
     * getRoleIdentity
     *
     * @return string
     */
    public function getRoleIdentity()
    {
        return $this->roleIdentity;
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
     * setParentRole
     *
     * @param AclRole|null $parentRole parent role
     *
     * @return void
     */
    public function setParentRole($parentRole)
    {
        $this->parentRole = $parentRole;
    }

    /**
     * getParentRole
     *
     * @return AclRole|null
     */
    public function getParentRole()
    {
        return $this->parentRole;
    }

    /**
     * getParent
     *
     * @return null|AclRole
     */
    public function getParent()
    {
        return $this->getParentRole();
    }

    /**
     * getRoleId
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->getRoleIdentity();
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
        $obj->roleIdentity = $this->getRoleIdentity();
        $obj->description = $this->getDescription();
        $obj->parentRole = $this->getParentRole();

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
} 