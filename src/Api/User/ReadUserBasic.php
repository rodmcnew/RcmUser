<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadUserBasic implements ReadUser
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
     * @return User|null
     */
    public function __invoke(
        User $requestUser
    ) {
        $result = $this->readUserResult->__invoke($requestUser);

        return $result->getData();
    }
}
