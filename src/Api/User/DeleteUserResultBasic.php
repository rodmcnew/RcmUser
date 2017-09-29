<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use RcmUser\User\Service\UserDataService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeleteUserResultBasic implements DeleteUserResult
{
    protected $userDataService;

    /**
     * @param UserDataService $userDataService
     */
    public function __construct(
        UserDataService $userDataService
    ) {
        $this->userDataService = $userDataService;
    }

    /**
     * @param User $requestUser
     *
     * @return Result
     */
    public function __invoke(
        User $requestUser
    ): Result {
        return $this->userDataService->deleteUser($requestUser);
    }
}
