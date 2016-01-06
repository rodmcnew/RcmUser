<?php

namespace RcmUser\Acl\Cache;

use RcmUser\Acl\Entity\AclResource;
use Zend\Cache\Storage\StorageInterface;

/**
 * Class ResourceCache
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Resource
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ResourceCache
{
    /**
     * ['resourceId': '{AclResource}']
     *
     * @var StorageInterface
     */
    protected $resourceStorage;

    /**
     * ['providerId': ['resourceId']]
     *
     * @var StorageInterface
     */
    protected $providerIndexStorage;

    /**
     * Resource constructor.
     *
     * @param StorageInterface $resourceStorage
     * @param StorageInterface $providerIndexStorage
     */
    public function __construct(
        StorageInterface $resourceStorage,
        StorageInterface $providerIndexStorage
    ) {
        $this->resourceStorage = $resourceStorage;
        $this->providerIndexStorage = $providerIndexStorage;
    }

    /**
     * get
     *
     * @param string $resourceId
     *
     * @return AclResource|null
     */
    public function get($resourceId)
    {
        return $this->resourceStorage->getItem($resourceId);
    }

    /**
     * set
     *
     * @param AclResource $resource
     *
     * @return void
     */
    public function set(AclResource $resource)
    {
        $this->resourceStorage->setItem($resource->getResourceId(), $resource);
    }

    /**
     * getProviderResources
     *
     * @param string $providerId
     *
     * @return array|null
     * @throws \Exception
     */
    public function getProviderResources($providerId)
    {
        $resourceIds = $this->providerIndexStorage->getItem($providerId);

        if ($resourceIds === null) {
            return null;
        }

        $resources = [];

        foreach ($resourceIds as $resourceId) {
            $resource = $this->get($resourceId);
            if ($resource == null) {
                throw new \Exception('Resource could not be found in cache');
            }

            $resources[$resourceId] = $resource;
        }

        return $resources;
    }

    /**
     * setProviderResources
     *
     * @param string $providerId
     * @param array  $resources Expects ALL Resource for the provider
     *
     * @return void
     */
    public function setProviderResources($providerId, $resources)
    {
        $index = [];

        /** @var AclResource $resource */
        foreach ($resources as $resource) {
            $this->set($resource);
            $index[] = $resource->getResourceId();
        }

        $this->providerIndexStorage->setItem($providerId, $index);
    }
}
