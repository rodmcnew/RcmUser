<?php

namespace RcmUser\Api\Authentication;

use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\User\Entity\User;
use Zend\Authentication\Result;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCredentialsBasic implements ValidateCredentials
{
    protected $userAuthenticationService;

    /**
     * @param UserAuthenticationService $userAuthenticationService
     */
    public function __construct(
        UserAuthenticationService $userAuthenticationService
    ) {
        $this->userAuthenticationService = $userAuthenticationService;
    }

    /**
     * @param User $requestUser
     *
     * @return Result
     */
    public function __invoke(
        User $requestUser
    ): Result {
        return $this->userAuthenticationService->validateCredentials($requestUser);
    }
}
