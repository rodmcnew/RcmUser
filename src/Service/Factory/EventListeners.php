<?php

namespace RcmUser\Service\Factory;

use RcmUser\Event\ListenerCollection;
use RcmUser\Event\Listeners;
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
 * @package   RcmUser\Service\Factory
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
     * @return array|mixed|object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $listeners = new ListenerCollection(
            $serviceLocator
        );

        $listeners->addListener('RcmUser\User\UserDataServiceListeners');

        $listeners->addListener('RcmUser\Authentication\UserAuthenticationServiceListeners');

        $listeners->addListener('RcmUser\User\UserRoleDataServiceListeners');

        return $listeners;
    }
}
