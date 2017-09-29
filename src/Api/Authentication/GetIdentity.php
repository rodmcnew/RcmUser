<?php

namespace RcmUser\Api\Authentication;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\User\Entity\User;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetIdentity
{
    /**
     * Get the current User (logged in User) from Auth'd session
     * or returns $default is there is no User Auth'd
     *
     * @param ServerRequestInterface $request
     * @param null                   $default
     *
     * @return User|null
     */
    public function __invoke(
        ServerRequestInterface $request,
        $default = null
    );
}
