<?php

namespace RcmUser\Acl\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * AclResourceBuilder.
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
class AclResourceBuilder implements FactoryInterface
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
        /** @var \RcmUser\Acl\Entity\RootAclResource $rootResource */
        $rootResource = $serviceLocator->get(
            'RcmUser\Acl\RootAclResource'
        );

        $service = new \RcmUser\Acl\Builder\AclResourceBuilder(
            $rootResource
        );

        return $service;
    }
}
