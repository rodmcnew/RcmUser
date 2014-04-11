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

use RcmUser\Acl\Service\AclResourceService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BjyResourceProvider implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $resourceProvider = $serviceLocator->get('RcmUser\Acl\Service\AclResourceService');

        $service = new \RcmUser\Acl\Provider\BjyResourceProvider();
        $service->setRcmUserResourceProvider($resourceProvider);

        return $service;
    }
}