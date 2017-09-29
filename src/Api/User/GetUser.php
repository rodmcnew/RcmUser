<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetUser
{
    /**
     * returns a user from the data source
     * based on the data in the provided User object (User::id and User::username)
     *
     * @param User $requestUser
     *
     * @return User|null
     */
    public function __invoke(
        User $requestUser
    );
}
