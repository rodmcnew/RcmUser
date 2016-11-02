<?php

namespace RcmUser\Event;

use Zend\EventManager\EventManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserEventManagerFactory
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class UserEventManagerFactory implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return EventManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new UserEventManager(UserEventManager::class);

        return $service;
    }
}
