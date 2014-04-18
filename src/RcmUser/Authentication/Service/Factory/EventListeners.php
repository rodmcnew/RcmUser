<?php
/**
 * EventListeners.php
 *
 * EventListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Authentication\Service\Factory;

use RcmUser\Authentication\Event\AuthenticatePreListener;
use RcmUser\Authentication\Event\ClearIdentityListener;
use RcmUser\Authentication\Event\GetIdentityListener;
use RcmUser\Authentication\Event\ValidateCredentialsPreListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * EventListeners
 *
 * EventListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class EventListeners implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return array|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $auth = $serviceLocator->get('RcmUser\Authentication\AuthenticationService');

        // Auth
        $listeners = array();

        $validateCredentialsPreListener = new ValidateCredentialsPreListener();
        $validateCredentialsPreListener->setAuthService($auth);

        $listeners[] = $validateCredentialsPreListener;

        $authenticatePreListener = new AuthenticatePreListener();
        $authenticatePreListener->setAuthService($auth);

        $listeners[] = $authenticatePreListener;

        $getIdentityListener = new GetIdentityListener();
        $getIdentityListener->setAuthService($auth);

        $listeners[] = $getIdentityListener;

        $clearIdentityListener = new ClearIdentityListener();
        $clearIdentityListener->setAuthService($auth);

        $listeners[] = $clearIdentityListener;

        return $listeners;
    }
}