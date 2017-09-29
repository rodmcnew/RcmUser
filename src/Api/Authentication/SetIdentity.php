<?php

namespace RcmUser\Api\Authentication;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SetIdentity
{
    /**
     * @param ServerRequestInterface $request
     * @param User                   $identity
     *
     * @return void
     */
    public function __invoke(
        ServerRequestInterface $request,
        User $identity
    );
}
