<?php

namespace RcmUser\Api\Authentication;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ClearIdentity
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return void
     */
    public function __invoke(
        ServerRequestInterface $request
    );
}
