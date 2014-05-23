<?php
/**
 * RcmUserGetCurrentUser.php
 *
 * RcmUserGetCurrentUser
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

use RcmUser\Acl\Service\AuthorizeService;
use RcmUser\Service\RcmUserService;
use Zend\View\Helper\AbstractHelper;

/**
 * Class RcmUserGetCurrentUser
 *
 * RcmUserGetCurrentUser
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
class RcmUserGetCurrentUser extends AbstractHelper
{

    /**
     * @var RcmUserService
     */
    protected $rcmUserService;

    /**
     * __construct
     *
     * @param RcmUserService $rcmUserService rcmUserService
     */
    public function __construct(
        RcmUserService $rcmUserService
    ) {
        $this->rcmUserService = $rcmUserService;
    }

    /**
     * __invoke
     *
     * @param string $resourceId resourceId
     * @param string $privilege  privilege
     * @param string $providerId providerId
     *
     * @return bool
     */
    public function __invoke($resourceId, $privilege = null, $providerId = null)
    {
        $user = $this->rcmUserService->getCurrentUser();

        return $user;
    }
}
