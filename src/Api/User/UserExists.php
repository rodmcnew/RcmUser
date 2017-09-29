<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UserExists
{
    /**
     * returns true if the user exists in the data source
     *
     * @param User $requestUser
     *
     * @return bool
     */
    public function __invoke(
        User $requestUser
    ): bool;
}
