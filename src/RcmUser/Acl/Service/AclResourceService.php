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
use RcmUser\Exception\RcmUserException;


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
     * @future
     * getResource - Get a resource and all of its parents
     * getProviderResourcesByResourceId
     *
     * @param $providerId
     * @param $resourceId
     *
     * @return array
     */
    public function getResource($providerId, $resourceId)
    {
        $providers = $this->getResourceProviders();
        $resources = array();

        if (!isset($providers[$providerId])) {

            return array();
        }

        $resource = $this->buildValidResource(
            $providers[$providerId]->getResource($resourceId)
        );

        $resources[$resource->getResourceId()] = $resource;

        if ($resource->getParentResourceId()
            == $this->getRootResource()->getResourceId()
        ) {

            return $resources;
        } else {

            $parentResources = $this->getResource(
                $providerId,
                $resource->getParentResourceId()
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
        $providers = $this->getResourceProviders();

        foreach ($providers as $providerId => $provider) {

            $providerResources = $provider->getResources(); //

            $resources = $this->prepareProviderResources(
                $providerResources
            );

            $this->resources = array_merge($resources, $this->resources);
        }

        return $this->resources;
    }

    /**
     * getAllResources - All resources
     * returns a list of all resources
     * This is used to displays or utilities only, not
     *
     * @param bool $refresh refresh
     *
     * @return array
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function getAllResources($refresh = false)
    {
        if (!$this->isCached || $refresh) {

            $providers = $this->getResourceProviders();

            foreach ($providers as $provider) {

                $providerResources = $provider->getResources();

                $resources = $this->prepareProviderResources(
                    $providerResources
                );

                $this->resources = array_merge($resources, $this->resources);
            }

            $this->isCached = true;
        }

        return $this->resources;
    }

    /**
     * getResourcesWithNamespaced
     *
     * @param string $nsChar  nsChar
     * @param bool   $refresh $refresh
     *
     * @return array
     */
    public function getResourcesWithNamespaced($nsChar = '.', $refresh = false)
    {
        $aclResources = array();
        $resources = $this->getNamespacedResources($nsChar, $refresh);

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
     * @param bool   $refresh $refresh
     *
     * @return array
     */
    public function getNamespacedResources($nsChar = '.', $refresh = false)
    {
        $aclResources = array();
        $resources = $this->getAllResources($refresh);

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
    ) {
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
     * prepareProviderResources
     *
     * @param array $providerResources providerResources
     *
     * @return array
     */
    public function prepareProviderResources($providerResources)
    {
        $resources = array();

        $resources[$this->rootResource->getResourceId()]
            = $this->rootResource;

        foreach ($providerResources as $resourceId => $resource) {

            $res = $this->buildValidResource($resource);
            $res = $this->buildValidParent($res);

            // @todo - might implement duplicate check
            //if(isset($this->resources[$res->getResourceId()])){

            //    throw new RcmUserException(
            //          'Resource id is invalid, resource id ' .
            //          $res->getResourceId() . ' already exists.'
            //    );
            //}

            $resources[$res->getResourceId()] = $res;
        }

        return $resources;
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

    protected function addRootResource()
    {
        if (!isset($this->resources[$this->rootResource->getResourceId()])) {

            $this->resources[$this->rootResource->getResourceId()]
                = $this->rootResource;
        }
    }

} 