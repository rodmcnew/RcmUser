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

class AclResourceService implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('RcmUser\Acl\Config');

        $resourceProviders = $config->get('ResourceProviders', array());

        foreach ($resourceProviders as $key => $factory) {

            $resourceProviders[$key] = $serviceLocator->get($factory);
        }


        $service = new \RcmUser\Acl\Service\AclResourceService();
        $service->setResourceProviders($resourceProviders);

        return $service;
    }
}