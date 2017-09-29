<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetUserByUsername
{
    /**
     * @param string $username
     *
     * @return User|null
     */
    public function __invoke(
        $username
    );
}
