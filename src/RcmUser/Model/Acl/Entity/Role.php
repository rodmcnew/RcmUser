<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Acl\Entity;

use Zend\Permissions\Acl\Role\RoleInterface;


/**
 * Class Role
 *
 * @package RcmUser\Model\Acl\Entity
 */
class Role implements RoleInterface
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
     * @return string|void
     */
    public function getRoleId()
    {
        return $this->getRoleIdentity();
    }
} 