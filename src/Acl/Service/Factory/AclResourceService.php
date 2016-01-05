<?php

namespace RcmUser\Acl\Service\Factory;

use RcmUser\Acl\Entity\RootAclResource;
use RcmUser\Acl\Entity\RootResource;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * AclResourceService
 *
 * AclResourceService Factory
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclResourceService implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Acl\Service\AclResourceService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('RcmUser\Acl\Config');

        $resourceProviders = $config->get(
            'ResourceProviders',
            []
        );

        $rootResource = new RootAclResource();

        $service = new \RcmUser\Acl\Service\AclResourceService($rootResource);
        $service->setResourceProviders($resourceProviders);
        $service->setServiceLocator($serviceLocator);

        return $service;
    }
}
