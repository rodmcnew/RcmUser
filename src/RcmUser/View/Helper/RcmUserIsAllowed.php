<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RcmUser\View\Helper;

use RcmUser\Acl\Service\UserAuthorizeService;
use Zend\View\Helper\AbstractHelper;

class RcmUserIsAllowed extends AbstractHelper
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
