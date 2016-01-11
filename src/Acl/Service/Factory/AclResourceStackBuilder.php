<?php

namespace RcmUser\Acl\Service\Factory;

use RcmUser\Acl\Provider\ResourceProviderInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * AclResourceStackBuilder
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
class AclResourceStackBuilder implements FactoryInterface
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
        /** @var ResourceProviderInterface $resourceProvider */
        $resourceProvider = $serviceLocator->get(
            'RcmUser\Acl\ResourceProvider'
        );

        $service = new \RcmUser\Acl\Builder\AclResourceStackBuilder(
            $resourceProvider
        );

        return $service;
    }
}
