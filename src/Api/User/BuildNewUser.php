<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildNewUser
{
    /**
     * @param array $options
     *
     * @return User
     */
    public function __invoke(
        array $options = []
    ): User;
}
