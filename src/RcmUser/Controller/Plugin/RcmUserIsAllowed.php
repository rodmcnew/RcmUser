<?php

namespace RcmUser\Controller\Plugin;

use RcmUser\Acl\Service\BjyAuthorizeService;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;


class RcmUserIsAllowed extends AbstractPlugin
{

    protected $authorizeService;

    public function __construct(BjyAuthorizeService $authorizeService)
    {
        $this->authorizeService = $authorizeService;
    }

    public function __invoke($resource, $privilege = null, $user = null)
    {
        return $this->authorizeService->isAllowed($resource, $privilege, $user);
    }
}
