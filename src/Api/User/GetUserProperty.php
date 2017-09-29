<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetUserProperty
{
    /**
     * @param User   $user
     * @param string $propertyNameSpace
     * @param null   $default
     * @param bool   $refresh
     *
     * @return mixed
     */
    public function __invoke(
        User $user,
        $propertyNameSpace,
        $default = null,
        $refresh = false
    );
}
