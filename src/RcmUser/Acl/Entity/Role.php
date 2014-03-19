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


/**
 * Class Role
 *
 * @package RcmUser\Acl\Entity
 */
class Role
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $parentRoleId;
    /**
     * @var string
     */
    protected $roleName;

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
     * @param int $parentRoleId
     */
    public function setParentRoleId($parentRoleId)
    {
        $this->parentRoleId = (int)$parentRoleId;
    }

    /**
     * @return int
     */
    public function getParentRoleId()
    {
        return $this->parentRoleId;
    }

    /**
     * @param string $roleName
     */
    public function setRoleName($roleName)
    {
        $this->roleName = (string)$roleName;
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }
} 