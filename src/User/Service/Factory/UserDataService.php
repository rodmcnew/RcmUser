<?php

namespace RcmUser\User\Service\Factory;

use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserDataService
 *
 * UserDataService
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
class UserDataService implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return \RcmUser\User\Service\UserDataService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $cfg = $serviceLocator->get('RcmUser\User\Config');
        /** @var \RcmUser\User\Db\UserDataMapper $userDataMapper */
        $userDataMapper = $serviceLocator->get(
            \RcmUser\User\Db\UserDataMapper::class
        );

        /** @var EventManagerInterface $eventManager */
        $eventManager = $serviceLocator->get(
            \RcmUser\Event\UserEventManager::class
        );

        $service = new \RcmUser\User\Service\UserDataService($eventManager);
        $service->setDefaultUserState(
            $cfg->get(
                'DefaultUserState',
                null
            )
        );
        $service->setValidUserStates(
            $cfg->get(
                'ValidUserStates',
                []
            )
        );
        $service->setUserDataMapper($userDataMapper);

        return $service;
    }
}
