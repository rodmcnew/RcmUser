<?php

namespace RcmUser\Api\Acl;

use RcmUser\User\Entity\UserInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HasRoleBasedAccessUser
{
    /**
     * @param UserInterface|null $user
     * @param string             $roleId
     *
     * @return bool
     */
    public function __invoke(
        $user,
        $roleId
    ):bool;
}
