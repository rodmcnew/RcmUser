<?php

namespace RcmUser\User\Service\Factory;

use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserPropertyService
 *
 * UserPropertyService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserPropertyService implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return \RcmUser\User\Service\UserPropertyService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EventManagerInterface $eventManager */
        $eventManager = $serviceLocator->get(
            \RcmUser\Event\UserEventManager::class
        );

        $service = new \RcmUser\User\Service\UserPropertyService($eventManager);

        return $service;
    }
}
