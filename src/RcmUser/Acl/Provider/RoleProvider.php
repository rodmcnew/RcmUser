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
        $roles['r.guest'] = new Role('r.guest');
        $roles['r.user'] = new Role('r.user');
        $roles['r.admin'] = new Role('r.admin');
        $roles['r.admin']->setParent('r.user');

        return $roles;
    }
}
