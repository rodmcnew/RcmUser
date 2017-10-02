<?php

namespace RcmUser\Api\Acl;

use RcmUser\Acl\Service\AuthorizeService;
use RcmUser\User\Entity\UserInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsUserAllowedBasic implements IsUserAllowed
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
     * @param string             $resourceId
     * @param string|null        $privilege
     *
     * @return bool
     */
    public function __invoke(
        $user,
        $resourceId,
        $privilege = null
    ):bool {
        return $this->authorizeService->isAllowed(
            $resourceId,
            $privilege,
            null, // deprecated and not used
            $user
        );
    }
}
