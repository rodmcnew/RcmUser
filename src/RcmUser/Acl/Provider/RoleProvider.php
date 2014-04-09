<?php
/**
 *
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Acl\Role;
use BjyAuthorize\Provider\Role\ProviderInterface;

/**
 *
 */
class RoleProvider implements ProviderInterface
{

    /**
     * @return \Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles()
    {
        // @todo from data source
        $roles = array();
        $roles['guest'] = new Role('guest');
        $roles['user'] = new Role('user');
        $roles['admin'] = new Role('admin');
        $roles['admin']->setParent('user');

        return $roles;
    }
}
