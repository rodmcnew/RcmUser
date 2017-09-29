<?php

namespace RcmUser\Api\Acl;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Api\Authentication\GetIdentity;
use RcmUser\User\Entity\User;

/**
 * WARNING: This is not tested and my not work correctly
 *
 * @author James Jervis - https://github.com/jerv13
 */
class HasRoleBasedAccessBasic implements HasRoleBasedAccess
{
    protected $getIdentity;
    protected $hasRoleBasedAccessUser;

    /**
     * @param GetIdentity            $getIdentity
     * @param HasRoleBasedAccessUser $hasRoleBasedAccessUser
     */
    public function __construct(
        GetIdentity $getIdentity,
        HasRoleBasedAccessUser $hasRoleBasedAccessUser
    ) {
        $this->getIdentity = $getIdentity;
        $this->hasRoleBasedAccessUser = $hasRoleBasedAccessUser;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $roleId
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        $roleId
    ):bool
    {
        $user = $this->getIdentity->__invoke($request);

        if (!($user instanceof User)) {
            return false;
        }

        return $this->hasRoleBasedAccessUser->__invoke($user, $roleId);
    }
}
