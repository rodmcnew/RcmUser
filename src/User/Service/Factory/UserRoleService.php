<?php

namespace RcmUser\User\Service\Factory;

use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * UserRoleDataServiceListeners
 *
 * UserRoleDataServiceListeners Factory
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserRoleService implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return \RcmUser\User\Service\UserRoleService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EventManagerInterface $eventManager */
        $eventManager = $serviceLocator->get(
            \RcmUser\Event\UserEventManager::class
        );

        $userRolesDataMapper = $serviceLocator->get(
            \RcmUser\User\Db\UserRolesDataMapper::class
        );

        $service = new \RcmUser\User\Service\UserRoleService(
            $userRolesDataMapper,
            $eventManager
        );

        return $service;
    }
}
