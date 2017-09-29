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
     * @param User $requestUser
     *
     * @return Result
     */
    public function __invoke(
        User $requestUser
    ): Result;
}
