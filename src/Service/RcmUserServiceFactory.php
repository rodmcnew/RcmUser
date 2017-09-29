<?php

namespace RcmUser\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RcmUserServiceFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class RcmUserServiceFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface|ServiceLocatorInterface $serviceLocator
     *
     * @return RcmUserService
     */
    public function __invoke($serviceLocator)
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

        $service = new RcmUserService();
        $service->setUserDataService($userDataService);
        $service->setUserPropertyService($userPropertyService);
        $service->setUserAuthService($userAuthenticationService);
        $service->setAuthorizeService($authorizeService);

        return $service;
    }
}
