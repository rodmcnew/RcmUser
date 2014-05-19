<?php
/**
 * AclResourceService.php
 *
 * AclResourceService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Service;

use RcmUser\Acl\Entity\AclResource;
use RcmUser\Acl\Provider\ResourceProvider;
use RcmUser\Acl\Provider\ResourceProviderInterface;
use RcmUser\Exception\RcmUserException;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * AclResourceService
 *
 * AclResourceService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclResourceService
{
    const MAX_RESOURCE_NESTING = 10;
    /**
     * @var
     */
    protected $serviceLocator;
    /**
     * @var AclResource
     */
    protected $rootResource = null;

    /**
     * @var array of resource provider factories
     */
    protected $resourceProviders = array();

    /**
     * @var array
     */
    protected $resources = array();

    /**
     * @var bool
     */
    protected $isCached = false;

    /**
     * __construct
     *
     * @param AclResource|array $rootResource rootResource
     */
    public function __construct($rootResource)
    {
        $this->rootResource = $this->buildValidResource($rootResource);
    }

    /**
     * setServiceLocator
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return void
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * getServiceLocator
     *
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * getRootResource
     *
     * @return AclResource
     */
    public function getRootResource()
    {
        return $this->rootResource;
    }

    /**
     * setResourceProviders
     *
     * @param array $resourceProviders resourceProviders
     *
     * @return void
     */
    public function setResourceProviders($resourceProviders)
    {
        $this->resourceProviders = $resourceProviders;
    }

    /**
     * getResourceProviders
     *
     * @return array
     */
    public function getResourceProviders()
    {
        return $this->resourceProviders;
    }

    /**
     * getResource - Get a resource and all of its parents
     * getProviderResourcesByResourceId
     *
     * @param string $providerId providerId
     * @param string $resourceId resourceId
     * @param int    $nestLevel  nestLevel
     *
     * @return array
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function getResource($providerId, $resourceId, $nestLevel = 0)
    {
        if ($nestLevel > self::MAX_RESOURCE_NESTING) {

            throw new RcmUserException(
                'Max resource nesting exceded, max nesting level is '
                . self::MAX_RESOURCE_NESTING);
        }

        $resources = array();
        // add root
        $resources[$this->rootResource->getResourceId()]
            = $this->rootResource;

        if (!isset($this->resourceProviders[$providerId])) {

            return array();
        }

        $this->resourceProviders[$providerId] = $this->buildValidProvider(
            $this->resourceProviders[$providerId]
        );

        $resource = $this->resourceProviders[$providerId]->getResource($resourceId);
        $resource = $this->buildValidResource(
            $resource
        );

        $resource = $this->buildValidParent($resource);

        $resources[$resource->getResourceId()] = $resource;

        if ($resource->getParentResourceId()
            == $this->getRootResource()->getResourceId()
        ) {

            return $resources;
        } else {

            $parentResources = $this->getResource(
                $providerId,
                $resource->getParentResourceId(),
                ($nestLevel + 1)
            );

            $resources = array_merge($parentResources, $resources);

            return $resources;
        }
    }

    /**
     * getResources
     * returns a list of registered resources
     *
     * @return array
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function getResources()
    {
        // add root
        $this->resources[$this->rootResource->getResourceId()]
            = $this->rootResource;

        foreach ($this->resourceProviders as $providerId => $provider) {

            $this->resourceProviders[$providerId] = $this->buildValidProvider(
                $provider
            );

            $providerResources
                = $this->resourceProviders[$providerId]->getResources();

            $resources = array();

            foreach ($providerResources as $resourceId => $resource) {

                $res = $this->buildValidResource($resource);
                $res = $this->buildValidParent($res);

                if (!isset($this->resources[$res->getResourceId()])) {

                    $resources[$res->getResourceId()] = $res;
                }
            }

            $this->resources = array_merge($this->resources, $resources);
        }

        // make sure root cannot be over written
        $this->resources[$this->rootResource->getResourceId()]
            = $this->rootResource;

        return $this->resources;
    }

    /**
     * getAllResources - All resources
     * returns a list of all resources
     * This is used to displays or utilities only, not for ACL checks
     *
     * @param bool $refresh refresh
     *
     * @return array
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function getAllResources($refresh = false)
    {
        if (!$this->isCached || $refresh) {

            // add root
            $this->resources[$this->rootResource->getResourceId()]
                = $this->rootResource;

            foreach ($this->resourceProviders as $providerId => $provider) {

                $this->resourceProviders[$providerId] = $this->buildValidProvider(
                    $provider
                );

                $providerResources
                    = $this->resourceProviders[$providerId]->getResources();

                foreach ($providerResources as $resourceId => $resource) {

                    $resource = $this->buildValidResource($resource);

                    if (!isset($this->resources[$resource->getResourceId()])) {

                        $resources = $this->getResource(
                            $providerId,
                            $resourceId
                        );

                        $this->resources = array_merge($this->resources, $resources);
                    }

                }
            }

            // make sure root cannot be over written
            $this->resources[$this->rootResource->getResourceId()]
                = $this->rootResource;

            $this->isCached = true;
        }

        return $this->resources;
    }

    /**
     * getResourcesWithNamespace
     *
     * @param string $nsChar  nsChar
     * @param bool   $getAll  getAll
     * @param bool   $refresh $refresh
     *
     * @return array
     */
    public function getResourcesWithNamespace(
        $nsChar = '.', $getAll = true, $refresh = false
    )
    {
        $aclResources = array();
        $resources = $this->getNamespacedResources($nsChar, $getAll, $refresh);

        foreach ($resources as $ns => $res) {

            $resourceId = $res->getResourceId();
            $aclResources[$resourceId] = array();
            $aclResources[$resourceId]['resource'] = $res;
            $aclResources[$resourceId]['resourceNs'] = $ns;
        }

        return $aclResources;
    }

    /**
     * getNamespacedResources
     *
     * @param string $nsChar  nsChar
     * @param bool   $getAll  getAll
     * @param bool   $refresh $refresh
     *
     * @return array
     */
    public function getNamespacedResources(
        $nsChar = '.', $getAll = true, $refresh = false
    )
    {
        $aclResources = array();

        if ($getAll) {

            $resources = $this->getAllResources($refresh);
        } else {

            $resources = $this->getResources();
        }

        foreach ($resources as $res) {

            $ns = $this->createNamespaceId(
                $res,
                $resources,
                $nsChar
            );

            $aclResources[$ns] = $res;
        }

        ksort($aclResources);

        return $aclResources;
    }

    /**
     * createNamespaceId
     *
     * @param AclResource $aclResource  aclResource
     * @param array       $aclResources aclResources
     * @param string      $nsChar       nsChar
     *
     * @return string
     */
    public function createNamespaceId(
        AclResource $aclResource,
        $aclResources,
        $nsChar = '.'
    )
    {
        $parentId = $aclResource->getParentResourceId();
        $ns = $aclResource->getResourceId();
        if (!empty($parentId)) {

            $parent = $aclResources[$parentId];

            $ns = $this->createNamespaceId(
                    $parent,
                    $aclResources,
                    $nsChar
                ) . $nsChar . $ns;
        }

        return $ns;
    }

    /**
     * buildValidResource
     *
     * @param mixed $resource resource
     *
     * @return AclResource
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function buildValidResource($resource)
    {
        if ($resource instanceof AclResource) {

            return $resource;
        }

        if (is_array($resource)) {

            $res = new AclResource($resource['resourceId']);
            $res->populate($resource);

            return $res;
        }

        throw new RcmUserException(
            'Resource is not valid: ' . var_export($resource, true)
        );
    }

    /**
     * buildValidParent
     *
     * @param AclResource $resource resource
     *
     * @return AclResource
     */
    public function buildValidParent(AclResource $resource)
    {
        $parentId = $resource->getParentResourceId();

        if (empty($parentId)) {

            $resource->setParentResourceId(
                $this->rootResource->getResourceId()
            );
        }

        return $resource;
    }

    protected function buildValidProvider($providerData)
    {
        if ($providerData instanceof ResourceProviderInterface) {

            return $providerData;
        }

        if (is_string($providerData)) {

            return $this->getServiceLocator()->get($providerData);
        }

        if (is_array($providerData)) {

            return new ResourceProvider($providerData);
        }

        throw new RcmUserException(
            'ResourceProvider is not valid: ' . var_export($providerData, true)
        );
    }
} 