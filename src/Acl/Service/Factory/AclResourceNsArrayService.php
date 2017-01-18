<?php

namespace RcmUser\Acl\Service\Factory;

use RcmUser\Acl\Provider\ResourceProviderInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AclResourceNsArrayService
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
class AclResourceNsArrayService implements FactoryInterface
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
        /** @var ResourceProviderInterface $resourceProvider */
        $resourceProvider = $serviceLocator->get(
            \RcmUser\Acl\Provider\ResourceProvider::class
        );

        /** @var \RcmUser\Acl\Builder\AclResourceStackBuilder $aclResourceStackBuilder */
        $aclResourceStackBuilder = $serviceLocator->get(
            \RcmUser\Acl\Builder\AclResourceStackBuilder::class
        );

        $service = new \RcmUser\Acl\Service\AclResourceNsArrayService(
            $resourceProvider,
            $aclResourceStackBuilder
        );

        return $service;
    }
}
