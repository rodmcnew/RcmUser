<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Authentication\Service\Factory;

use RcmUser\Authentication\Event\AuthenticatePreListener;
use RcmUser\Authentication\Event\ClearIdentityListener;
use RcmUser\Authentication\Event\GetIdentityListener;
use RcmUser\Authentication\Event\ValidateCredentialsPreListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventListeners implements FactoryInterface
{

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