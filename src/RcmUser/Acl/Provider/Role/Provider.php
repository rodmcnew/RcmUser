<?php
/**
 *
 */

namespace RcmUser\Acl\Provider\Role;

use BjyAuthorize\Acl\Role;
use BjyAuthorize\Provider\Role\ProviderInterface;

/**
 *
 */
class Provider implements ProviderInterface
{
    /**
     * @return \Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles()
    {
        // @todo from data source
        $roles = array();
        $roles[0] = new Role('guest');
        $roles[1] = new Role('user');
        $roles[2] = new Role('admin');
        $roles[2]->setParent('user');

        return $roles;
    }
}
