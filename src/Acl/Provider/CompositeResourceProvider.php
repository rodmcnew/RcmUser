<?php

namespace RcmUser\Acl\Provider;

use RcmUser\Acl\Entity\AclResource;
use Zend\Cache\Storage\StorageInterface;

/**
 * Class CompositeResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CompositeResourceProvider implements ResourceProviderInterface
{
    /**
     * PROVIDER_RESOURCES_KEY
     */
    const PROVIDER_RESOURCES_KEY = '::PROVIDER-RESOURCES::';
    /**
     * @var array
     */
    protected $resourceProviders = [];

    /**
     * @var AclResource
     */
    protected $rootResource;

    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * CompositeResourceProvider constructor.
     *
     * @param AclResource      $rootResource
     * @param StorageInterface $cache
     */
    public function __construct(
        AclResource $rootResource,
        StorageInterface $cache
    ) {
        $this->rootResource = $rootResource;
        $this->cache = $cache;
    }

    /**
     * add
     *
     * @param ResourceProviderInterface $resourceProvider
     *
     * @return void
     */
    public function add(ResourceProviderInterface $resourceProvider)
    {
        $this->resourceProviders[$resourceProvider->getProviderId()]
            = $resourceProvider;
    }

    /**
     * getProviderId
     *
     * @return string
     */
    public function getProviderId()
    {
        return $this->rootResource->getProviderId();
    }

    /**
     * getResources (ALL resources)
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources including run-time resources
     *
     * @return array
     */
    public function getResources()
    {
        $resources = $this->getAllResources();

        // @todo Tree resources

        return $resources;
    }

    /**
     * getAllResources
     *
     * @return array
     */
    public function getAllResources()
    {
        $resources = $this->cache->getItem(self::PROVIDER_RESOURCES_KEY);

        if ($resources === null) {
            $resources = [];
        }

        /** @var ResourceProviderInterface $resourceProvider */
        foreach ($this->resourceProviders as $resourceProvider) {
            $providerId = $resourceProvider->getProviderId();
            if (!array_key_exists($providerId, $resources)) {
                $resources[$providerId] = $resourceProvider->getAllResources();
            }
        }

        $this->cache->setItem(self::PROVIDER_RESOURCES_KEY, $resources);

        return $resources;
    }

    /**
     * getResource
     * Return the requested resource or null if not found
     * Can be used to return resources dynamically at run-time
     *
     * @param string $resourceId $resourceId
     *
     * @return AclResource|null
     */
    public function getResource($resourceId)
    {
        /** @var AclResource $resource */
        $resource = $this->cache->getItem($resourceId);

        if ($resource !== null) {
            return $resource;
        }

        /** @var ResourceProviderInterface $resourceProvider */
        foreach ($this->resourceProviders as $resourceProvider) {
            $hasResource = $resourceProvider->hasResource($resourceId);
            if ($hasResource) {
                /** @var AclResource $resource */
                $resource = $resourceProvider->getResource($resourceId);
                $parentResourceId = $resource->getParentResourceId();
                if (empty($parentResourceId)) {
                    $resource->setParentResource($this->rootResource);
                }
                $this->cache->setItem($resourceId, $resource);
                break;
            }
        }

        return $resource;
    }

    /**
     * hasResource
     *
     * @param string $resourceId
     *
     * @return bool
     */
    public function hasResource($resourceId)
    {
        $resource = $this->getResource($resourceId);

        return ($resource !== null);
    }
}
