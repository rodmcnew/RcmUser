<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RcmUser\View\Helper;

use RcmUser\Acl\Service\BjyAuthorizeService;
use Zend\View\Helper\AbstractHelper;

class RcmUserIsAllowed extends AbstractHelper
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
