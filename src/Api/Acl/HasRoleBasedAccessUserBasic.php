<?php

namespace RcmUser\Api\Acl;

use RcmUser\Acl\Service\AuthorizeService;
use RcmUser\User\Entity\User;

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
     * @param User|null $user
     * @param string    $roleId
     *
     * @return bool
     */
    public function __invoke(
        $user,
        $roleId
    ):bool {
        if (!($user instanceof User)) {
            return false;
        }

        return $this->authorizeService->hasRoleBasedAccess($user, $roleId);
    }
}
