<?php
/**
 *
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Acl\Role;
use BjyAuthorize\Provider\Role\ProviderInterface;
use RcmUser\Acl\Db\AclRoleDataMapperInterface;
use RcmUser\Acl\Entity\AclRole;

/**
 *
 */
class BjyRoleProvider implements ProviderInterface
{

    protected $aclRoleDataMapper;

    protected $roles = array();

    /**
     * @param AclRoleDataMapperInterface $aclRoleDataMapper
     */
    public function setAclRoleDataMapper(AclRoleDataMapperInterface $aclRoleDataMapper)
    {
        $this->aclRoleDataMapper = $aclRoleDataMapper;
    }

    /**
     * @return AclRoleDataMapperInterface
     */
    public function getAclRoleDataMapper()
    {
        return $this->aclRoleDataMapper;
    }

    /**
     * @return \Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles()
    {
        // cache
        if(!empty($this->roles)){

            return $this->roles;
        }

        $alcRoleDataMapper = $this->getAclRoleDataMapper();

        $results = $alcRoleDataMapper->fetchAll();

        if(!$results->isSuccess()){
            // @todo Throw error?
            return array();
        }

        // @todo
        // BJY does not recognize roles by unique/abstract id, so duplicate identity are not supported, even if they are a child
        // would be nice to support id or namespace so the role user and user.blog.user would not cause a conflict
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
