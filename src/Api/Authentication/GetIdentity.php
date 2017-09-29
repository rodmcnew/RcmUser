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
