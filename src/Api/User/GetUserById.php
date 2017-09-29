<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetUserById
{
    /**
     * @param int|string $userId
     *
     * @return User|null
     */
    public function __invoke(
        $userId
    );
}
