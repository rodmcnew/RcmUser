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

class AuthenticationService implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $storage = $serviceLocator->get('RcmUser\Authentication\Storage');
        $adapter = $serviceLocator->get('RcmUser\Authentication\Adapter');

        return new \RcmUser\Authentication\Service\AuthenticationService($storage, $adapter);
    }
}