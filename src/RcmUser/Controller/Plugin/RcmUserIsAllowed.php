<?php
/**
 * RcmUserIsAllowed.php
 *
 * RcmUserIsAllowed
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Controller\Plugin
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */
namespace RcmUser\Controller\Plugin;

use RcmUser\Acl\Service\UserAuthorizeService;
use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\User\Entity\User;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * RcmUserIsAllowed
 *
 * RcmUserIsAllowed
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Controller\Plugin
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserIsAllowed extends AbstractPlugin
{

    /**
     * @var UserAuthorizeService $userAuthorizeService
     */
    protected $userAuthorizeService;

    /**
     * @var UserAuthenticationService $userAuthService
     */
    protected $userAuthService;

    /**
     * __construct
     *
     * @param UserAuthorizeService      $userAuthorizeService userAuthorizeService
     * @param UserAuthenticationService $userAuthService      userAuthService
     */
    public function __construct(UserAuthorizeService $userAuthorizeService, UserAuthenticationService $userAuthService)
    {
        $this->userAuthorizeService = $userAuthorizeService;
        $this->userAuthService = $userAuthService;
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
    public function __invoke($resource, $privilege = null)
    {
        $user = $this->userAuthService->getIdentity();

        return $this->userAuthorizeService->isAllowed($resource, $privilege, $user);
    }
}
