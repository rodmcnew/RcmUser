<?php

namespace RcmUser\Api\Acl;

use RcmUser\Acl\Service\AuthorizeService;
use RcmUser\User\Entity\UserInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HasRoleBasedAccessUserBasic implements HasRoleBasedAccessUser
{
    protected $authorizeService;

    /**
     * @param AuthorizeService $authorizeService
     */
    public function __construct(
        AuthorizeService $authorizeService
    ) {
        $this->authorizeService = $authorizeService;
    }

    /**
     * @param UserInterface|null $user
     * @param string             $roleId
     *
     * @return bool
     */
    public function __invoke(
        $user,
        $roleId
    ):bool {
        if (!($user instanceof UserInterface)) {
            return false;
        }

        return $this->authorizeService->hasRoleBasedAccess($user, $roleId);
    }
}
