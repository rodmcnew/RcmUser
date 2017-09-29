<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadUser
{
    /**
     * @param User $requestUser
     *
     * @return User|null
     */
    public function __invoke(
        User $requestUser
    );
}
