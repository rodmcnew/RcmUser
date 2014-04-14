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

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Zend\Permissions\Acl\Role\RoleInterface;


/**
 * Class BjyAclRole
 *
 * @package RcmUser\Acl\Entity
 */
class BjyAclRole extends AclRole implements HierarchicalRoleInterface
{

    /**
     * @return int|null|RoleInterface
     */
    public function getParent()
    {

        if (($this->parentRole instanceof AclRole)) {

            return $this->parentRole->getRoleIdentity();
        }

        return $this->parentRole;
    }
} 