<?php

namespace RcmUser\Service\Factory;

use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * RcmUserService
 *
 * RcmUserService
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
class RcmUserService implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Service\RcmUserService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userAuthenticationService = $serviceLocator->get(
            \RcmUser\Authentication\Service\UserAuthenticationService::class
        );
        $userDataService = $serviceLocator->get(
            \RcmUser\User\Service\UserDataService::class
        );
        $userPropertyService = $serviceLocator->get(
            \RcmUser\User\Service\UserPropertyService::class
        );
        $authorizeService = $serviceLocator->get(
            \RcmUser\Acl\Service\AuthorizeService::class
        );

        $service = new \RcmUser\Service\RcmUserService();
        $service->setUserDataService($userDataService);
        $service->setUserPropertyService($userPropertyService);
        $service->setUserAuthService($userAuthenticationService);
        $service->setAuthorizeService($authorizeService);

        return $service;
    }
}
