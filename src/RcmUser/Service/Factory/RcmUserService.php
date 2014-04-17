<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Service\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RcmUserService implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authServ = $serviceLocator->get('RcmUser\Authentication\Service\UserAuthenticationService');
        $userDataService = $serviceLocator->get('RcmUser\User\Service\UserDataService');
        $userPropertyService = $serviceLocator->get('RcmUser\User\Service\UserPropertyService');
        $userAuthorizeService = $serviceLocator->get('RcmUser\Acl\Service\UserAuthorizeService');

        $service = new \RcmUser\Service\RcmUserService();
        $service->setUserDataService($userDataService);
        $service->setUserPropertyService($userPropertyService);
        $service->setUserAuthService($authServ);
        $service->setUserAuthorizeService($userAuthorizeService);

        return $service;
    }
}