<?php
/**
 * BjyRoleProvider.php
 *
 * BjyRoleProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Acl\Role;
use BjyAuthorize\Provider\Role\ProviderInterface;
use RcmUser\Acl\Db\AclRoleDataMapperInterface;
use RcmUser\Acl\Entity\AclRole;

/**
 * BjyRoleProvider
 *
 * BjyRoleProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class BjyRoleProvider implements ProviderInterface
{

    /**
     * @var
     */
    protected $aclRoleDataMapper;

    /**
     * @var array
     */
    protected $roles = array();

    /**
     * setAclRoleDataMapper
     *
     * @param AclRoleDataMapperInterface $aclRoleDataMapper aclRoleDataMapper
     *
     * @return void
     */
    public function setAclRoleDataMapper(
        AclRoleDataMapperInterface $aclRoleDataMapper
    ) {
        $this->aclRoleDataMapper = $aclRoleDataMapper;
    }

    /**
     * getAclRoleDataMapper
     *
     * @return AclRoleDataMapperInterface
     */
    public function getAclRoleDataMapper()
    {
        return $this->aclRoleDataMapper;
    }

    /**
     * getRoles
     *
     * @return array|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles()
    {
        // cache
        if (!empty($this->roles)) {

            return $this->roles;
        }

        $alcRoleDataMapper = $this->getAclRoleDataMapper();

        $results = $alcRoleDataMapper->fetchAll();

        if (!$results->isSuccess()) {
            // @todo Throw error?
            return array();
        }

        // @todo
        // BJY does not recognize roles by unique/abstract id,
        // so duplicate identity are not supported, even if they are a child
        // would be nice to support id or namespace
        // so the role user and user.blog.user would not cause a conflict
        // @see var_dump($this->createNamespaceId($role, $aclRoles));
        $aclRoles = $results->getData();

        return $aclRoles;

        /* TEST
        $roles = array();
        $roles['guest'] = new Role('guest');
        $roles['user'] = new Role('user');
        $roles['admin'] = new Role('admin');
        $roles['admin']->setParent('user');

        return $roles;
        */
    }
}
