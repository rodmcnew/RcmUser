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

use RcmUser\User\Service\UserDataPrepService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserDataPrep implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $dm = $serviceLocator->get('RcmUser\User\UserDataMapper');
        $encrypt = $serviceLocator->get('RcmUser\User\Encryptor');

        $service = new UserDataPrepService();
        $service->setUserDataMapper($dm);
        $service->setEncryptor($encrypt);

        return $service;
    }
}
