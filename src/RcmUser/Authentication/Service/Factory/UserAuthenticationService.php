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

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserAuthenticationService implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //@todo - factory not required: $auth = $serviceLocator->get('RcmUser\Authentication\AuthenticationService');

        $service = new \RcmUser\Authentication\Service\UserAuthenticationService();

        return $service;
    }
}