<?php
/**
 * BjyAclRole.php
 *
 * BjyAclRole
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

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Zend\Permissions\Acl\Role\RoleInterface;


/**
 * BjyAclRole
 *
 * BjyAclRole
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
class BjyAclRole extends AclRole implements HierarchicalRoleInterface
{

    /**
     * getParent
     *
     * @return null|string|RoleInterface
     */
    public function getParent()
    {
        return $this->parentRoleId;
    }
} 