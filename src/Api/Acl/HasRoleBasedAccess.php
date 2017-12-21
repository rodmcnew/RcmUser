<?php

namespace RcmUser\Api\Acl;

use Psr\Http\Message\ServerRequestInterface;

/**
 * WARNING: This is not tested and my not work correctly
 * @author James Jervis - https://github.com/jerv13
 */
interface HasRoleBasedAccess
{
    /**
     * Check if current user has access based on role inheritance
     * NOTE: This does NOT use rules, just determines if the user has a role in the linage
     *
     * @param ServerRequestInterface $request
     * @param string                 $roleId
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        $roleId
    ):bool;
}
