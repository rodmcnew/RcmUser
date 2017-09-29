<?php

namespace RcmUser\Api\User;

use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreateUserBasic implements CreateUser
{
    protected $createUserResult;

    /**
     * @param CreateUserResult $createUserResult
     */
    public function __construct(
        CreateUserResult $createUserResult
    ) {
        $this->createUserResult = $createUserResult;
    }

    /**
     * @param User $requestUser
     *
     * @return User|null
     */
    public function __invoke(
        User $requestUser
    ) {
        $result = $this->createUserResult->__invoke(
            $requestUser
        );

        return $result->getData();
    }
}
