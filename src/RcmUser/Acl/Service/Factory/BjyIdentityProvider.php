<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BjyIdentityProvider implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed|Provider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $rcmUserService = $serviceLocator->get('RcmUser\Service\RcmUserService');
        $cfg = $serviceLocator->get('RcmUser\Acl\Config');

        $service = new \RcmUser\Acl\Provider\BjyIdentityProvider();
        $service->setUserService($rcmUserService);
        $service->setDefaultRoleIdentities($cfg->get('DefaultRoleIdentities', array()));

        return $service;
    }
}