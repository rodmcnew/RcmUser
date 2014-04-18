<?php

namespace RcmUser\Controller\Plugin;

use RcmUser\Acl\Service\UserAuthorizeService;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;


class RcmUserIsAllowed extends AbstractPlugin
{

    protected $userAuthorizeService;

    public function __construct(UserAuthorizeService $userAuthorizeService)
    {
        $this->userAuthorizeService = $userAuthorizeService;
    }

    public function __invoke($resource, $privilege = null, $user = null)
    {
        return $this->userAuthorizeService->isAllowed($resource, $privilege, $user);
    }
}
