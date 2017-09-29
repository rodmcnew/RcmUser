<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UserExistsBasic implements UserExists
{
    protected $readUserResult;

    /**
     * @param ReadUserResult $readUserResult
     */
    public function __construct(
        ReadUserResult $readUserResult
    ) {
        $this->readUserResult = $readUserResult;
    }

    /**
     * @param User $requestUser
     *
     * @return bool
     */
    public function __invoke(
        User $requestUser
    ): bool {
        $result = $this->readUserResult->__invoke($requestUser);

        return $result->isSuccess();
    }
}
