<?php
/**
 * RcmUserIsAllowed.php
 *
 * RcmUserIsAllowed
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\View\Helper
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\View\Helper;

use RcmUser\Acl\Service\UserAuthorizeService;
use Zend\View\Helper\AbstractHelper;

/**
 * Class RcmUserIsAllowed
 *
 * RcmUserIsAllowed
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\View\Helper
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserIsAllowed extends AbstractHelper
{

    /**
     * @var \RcmUser\Acl\Service\UserAuthorizeService
     */
    protected $userAuthorizeService;

    /**
     * __construct
     *
     * @param UserAuthorizeService $userAuthorizeService userAuthorizeService
     */
    public function __construct(UserAuthorizeService $userAuthorizeService)
    {
        $this->userAuthorizeService = $userAuthorizeService;
    }

    /**
     * __invoke
     *
     * @param string $resource  resource
     * @param string $privilege privilege
     * @param User   $user      user
     *
     * @return bool
     */
    public function __invoke($resource, $privilege = null, $user = null)
    {
        return $this->userAuthorizeService->isAllowed($resource, $privilege, $user);
    }
}
