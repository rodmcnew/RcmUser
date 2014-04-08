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

use RcmUser\Acl\Provider\IdentityProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IdentiyProvider implements FactoryInterface
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

        $service = new IdentityProvider();
        $service->setUserService($rcmUserService);
        $service->setDefaultRoleIdentity($cfg->get('DefaultRoleIdentities', array()));

        return $service;
    }
}