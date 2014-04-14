<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Authentication\Service\Factory;


use RcmUser\Authentication\Adapter\UserAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Adapter implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $userDataService = $serviceLocator->get('RcmUser\User\Service\UserDataService');
        $encrypt = $serviceLocator->get('RcmUser\User\Encryptor');
        $adapter = new UserAdapter();
        $adapter->setUserDataService($userDataService);
        $adapter->setEncryptor($encrypt);

        return $adapter;
    }
}
