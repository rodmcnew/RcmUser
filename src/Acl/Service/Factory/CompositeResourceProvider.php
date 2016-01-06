<?php

namespace RcmUser\Acl\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CompositeResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CompositeResourceProvider implements FactoryInterface
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
        $config = $serviceLocator->get(
            'config '
        );

        $providerConfig = $config['RcmUser']['Acl\Config']['ResourceProviders'];

        $resourceProviderBuilder = new \RcmUser\Acl\Builder\ResourceProviderBuilder(
            $serviceLocator
        );

        /** @var \RcmUser\Acl\Entity\RootAclResource $rootResource */
        $rootResource = $serviceLocator->get(
            'RcmUser\Acl\RootAclResource'
        );

        /** @var \RcmUser\Acl\Cache\ResourceCache $resourceCache */
        $resourceCache = $serviceLocator->get(
            'RcmUser\Acl\ResourceCache'
        );

        $resourceBuilder = new \RcmUser\Acl\Builder\AclResourceBuilder(
            $rootResource
        );

        $service = new \RcmUser\Acl\Provider\CompositeResourceProvider(
            $resourceCache,
            $resourceBuilder
        );

        foreach($providerConfig as $providerId => $providerData) {
            $provider = $resourceProviderBuilder->build($providerData, $providerId);
            $service->add($provider);
        }

        return $service;
    }
}
