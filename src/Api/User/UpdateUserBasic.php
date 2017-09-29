<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpdateUserBasic implements UpdateUser
{
    protected $updateUserResult;

    /**
     * @param UpdateUserResult $updateUserResult
     */
    public function __construct(
        UpdateUserResult $updateUserResult
    ) {
        $this->updateUserResult = $updateUserResult;
    }

    /**
     * @param User $requestUser
     *
     * @return User|null
     */
    public function __invoke(
        User $requestUser
    ) {
        $result = $this->updateUserResult->__invoke(
            $requestUser
        );

        return $result->getData();
    }
}
