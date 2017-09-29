<?php

namespace RcmUser\Api\User;

use RcmUser\Exception\RcmUserException;
use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildUser
{
    /**
     * @param User  $user
     * @param array $options
     *
     * @return User
     * @throws RcmUserException
     */
    public function __invoke(
        User $user,
        array $options = []
    ): User;
}
