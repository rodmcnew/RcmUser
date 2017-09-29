<?php

namespace RcmUser\Api\Acl;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface IsAllowed
{
    /**
     * @param ServerRequestInterface $request
     * @param string                 $resourceId
     * @param string|null            $privilege
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        $resourceId,
        $privilege = null
    ):bool;
}
