<?php

namespace RcmUser\Api\Acl;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface isUserAllowed
{
    /**
     * @param User|null   $user
     * @param string      $resourceId
     * @param string|null $privilege
     *
     * @return bool
     */
    public function __invoke(
        $user,
        $resourceId,
        $privilege = null
    ):bool;
}
