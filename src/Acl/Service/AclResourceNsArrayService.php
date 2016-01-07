<?php

namespace RcmUser\Acl\Service;

use RcmUser\Acl\Builder\AclResourceStackBuilder;
use RcmUser\Acl\Entity\AclResource;
use RcmUser\Acl\Provider\ResourceProviderInterface;

/**
 * Class AclResourceNsArrayService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   AclResource
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclResourceNsArrayService
{
    /**
     * @var AclResourceStackBuilder
     */
    protected $aclResourceStackBuilder;

    /**
     * @var ResourceProviderInterface
     */
    protected $resourceProvider;

    /**
     * @var string
     */
    protected $nsChar = '.';

    /**
     * AclResourceNsArrayBuilder constructor.
     *
     * @param ResourceProviderInterface $resourceProvider
     * @param AclResourceStackBuilder   $aclResourceStackBuilder
     */
    public function __construct(
        ResourceProviderInterface $resourceProvider,
        AclResourceStackBuilder $aclResourceStackBuilder
    ) {
        $this->resourceProvider = $resourceProvider;
        $this->aclResourceStackBuilder = $aclResourceStackBuilder;
    }

    /**
     * getResourcesWithNamespace
     *
     * @param string $resourceId resourceId
     * @param string $providerId providerId
     * @param bool   $refresh    refresh
     *
     * @return array
     */
    public function getResourcesWithNamespace()
    {
        $aclResources = [];
        $resources = $this->getNamespacedResources();
        /**
         * @var             $ns
         * @var AclResource $resource
         */
        foreach ($resources as $ns => $resource) {
            $resourceId = $resource->getResourceId();
            $aclResources[$resourceId] = $this->getNsModel($resource, $ns);
        }

        return $aclResources;
    }

    /**
     * getResourceWithNamespace
     *
     * @param null $resourceId
     *
     * @return array
     */
    public function getResourceWithNamespace(
        $resourceId = null
    ) {
        $resource = $this->resourceProvider->getResource($resourceId);

        $resourceTree = $this->aclResourceStackBuilder->build(
            $resource
        );

        $ns = $this->createNamespaceId(
            $resource,
            $resourceTree
        );

        return $this->getNsModel($resource, $ns);
    }

    /**
     * getNamespacedResources
     *
     * @param string $resourceId resourceId
     *
     * @return array
     */
    public function getNamespacedResources()
    {
        $aclResources = [];

        $resources = $this->resourceProvider->getResources();

        foreach ($resources as $resource) {
            $ns = $this->createNamespaceId(
                $resource,
                $resources
            );

            $aclResources[$ns] = $resource;
        }

        ksort($aclResources);

        return $aclResources;
    }

    /**
     * createNamespaceId
     *
     * @param AclResource $aclResource  aclResource
     * @param array       $aclResources aclResources
     *
     * @return string
     */
    public function createNamespaceId(
        AclResource $aclResource,
        $aclResources
    ) {
        $parentId = $aclResource->getParentResourceId();
        $ns = $aclResource->getResourceId();
        if (!empty($parentId) && isset($aclResources[$parentId])) {
            $parent = $aclResources[$parentId];

            $newns = $this->createNamespaceId(
                $parent,
                $aclResources
            );

            $ns = $newns . $this->nsChar . $ns;
        }

        return $ns;
    }

    /**
     * getNsModel
     *
     * @param $resource
     * @param $ns
     *
     * @return array
     */
    public function getNsModel($resource, $ns)
    {
        return [
            'resource' => $resource,
            'resourceNs' => $ns,
        ];
    }
}
