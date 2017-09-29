<?php

namespace RcmUser\Api\Authentication;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\User\Entity\User;
use Zend\Authentication\Result;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AuthenticateBasic implements Authenticate
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
     * @param ServerRequestInterface $request
     * @param User                   $requestUser
     *
     * @return Result
     */
    public function __invoke(
        ServerRequestInterface $request,
        User $requestUser
    ): Result {
        // NOTE: $request is not used, but it should
        return $this->userAuthenticationService->authenticate($requestUser);
    }
}
