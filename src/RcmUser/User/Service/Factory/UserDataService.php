<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Service\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserDataService implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dm = $serviceLocator->get('RcmUser\User\UserDataMapper');
        $vs = $serviceLocator->get('RcmUser\User\Service\UserValidatorService');
        $dps = $serviceLocator->get('RcmUser\User\Service\UserDataPrepService');

        $service = new \RcmUser\User\Service\UserDataService();
        $service->setUserDataMapper($dm);
        $service->setUserValidatorService($vs);
        $service->setUserDataPrepService($dps);

        return $service;
    }
}
