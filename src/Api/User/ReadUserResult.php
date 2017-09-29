<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;
use RcmUser\User\Result;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadUserResult
{
    /**
     * @param User $requestUser
     *
     * @return Result
     */
    public function __invoke(
        User $requestUser
    ): Result;
}
