<?php

namespace RcmUser\Api\Acl;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HasRoleBasedAccess
{
    /**
     * @param User|null $user
     * @param string    $roleId
     *
     * @return bool
     */
    public function __invoke(
        $user,
        $roleId
    ):bool;
}
