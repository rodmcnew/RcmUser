<?php

namespace RcmUser\Api\Authentication;

use RcmUser\User\Entity\User;
use Zend\Authentication\Result;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidateCredentials
{
    /**
     * Allows the validation of user credentials (username and password)
     * without creating an auth session.
     * Helpful for doing non-login authentication checks.
     *
     * @param User $requestUser
     *
     * @return Result
     */
    public function __invoke(
        User $requestUser
    ): Result;
}
