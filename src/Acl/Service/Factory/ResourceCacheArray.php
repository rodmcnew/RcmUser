<?php

namespace RcmUser\Acl\Service\Factory;

use RcmUser\Acl\Cache\ArrayStorage;
use RcmUser\Acl\Cache\ResourceCache;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ResourceCacheArray
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ResourceCacheArray implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Config\Config
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $resourceStorage = new ArrayStorage();

        $providerIndexStorage = new ArrayStorage();

        /** @var \RcmUser\Acl\Builder\AclResourceBuilder $resourceBuilder */
        $resourceBuilder = $serviceLocator->get(
            \RcmUser\Acl\Builder\AclResourceBuilder::class
        );

        $service = new ResourceCache(
            $resourceStorage,
            $providerIndexStorage,
            $resourceBuilder
        );

        return $service;
    }
}
