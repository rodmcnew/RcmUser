<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeleteUserBasic implements DeleteUser
{
    protected $deleteUserResult;

    /**
     * @param DeleteUserResult $deleteUserResult
     */
    public function __construct(
        DeleteUserResult $deleteUserResult
    ) {
        $this->deleteUserResult = $deleteUserResult;
    }

    /**
     * @param User $requestUser
     *
     * @return User|null
     */
    public function __invoke(
        User $requestUser
    ) {
        $result = $this->deleteUserResult->__invoke(
            $requestUser
        );

        return $result->getData();
    }
}
