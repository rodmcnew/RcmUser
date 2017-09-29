<?php

namespace RcmUser\Api\Authentication;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface IsIdentity
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        User $user
    ): bool;
}
