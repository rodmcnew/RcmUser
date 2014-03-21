<?php
/**
 *
 */

namespace RcmUser\Model\Acl\Provider\Identity;

use BjyAuthorize\Provider\Identity\ProviderInterface;

/**
 *
 */
class Provider implements ProviderInterface
{
    /**
     * Retrieve roles for the current identity
     *
     * @return string[]|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getIdentityRoles(){
        // @todo get from data source
        return array('user');
    }
}
