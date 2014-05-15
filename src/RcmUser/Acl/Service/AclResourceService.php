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
     * @param array $resources
     * @param null  $rootResource
     */
    public function __construct(
        $rootResource,
        $resources = array()
    ) {
        $this->rootResource = $rootResource;
    }

    /**
     * getRootResource
     *
     * @return string
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
     * getResources - Used by ACL - Runtime resources
     * returns a list of runtime resources
     *
     * @return array
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function getResources()
    {
        $providers = $this->getResourceProviders();

        foreach ($providers as $providerName => $provider) {

            $providerResources = $provider->getAvailableAtRuntime();

            $this->resources = $this->prepareProviderResources(
                $providerResources
            );
        }

        return $this->resources;
    }

    /**
     * getAllResources - All resources
     * returns a list of runtime resources
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

                $providerResources = $provider->getAll();

                $this->resources = $this->prepareProviderResources(
                    $providerResources
                );
            }

            $this->isCached = true;
        }

        return $this->resources;
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

        foreach ($providerResources as $val) {

            // populate if config array
            if (is_array($val)) {

                $res = new AclResource($val['resourceId']);
                $res->populate($val);
            } else {
                $res = $val;
            }

            if ($res->getParentResourceId() == null) {

                $res->setParentResourceId(
                    $this->rootResource->getResourceId()
                );
            }

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
     * getOrderedNameSpacedResources
     *
     * @param string $nsChar  nsChar
     * @param bool   $refresh $refresh
     *
     * @return array
     */
    public function getOrderedNameSpacedResources($nsChar = '.', $refresh = false)
    {
        $aclResources = array();
        $resources = $this->getAllResources($refresh);

        foreach ($resources as $res) {

            $resourceId = $res->getResourceId();
            $aclResources[$resourceId] = array();
            $aclResources[$resourceId]['resource'] = $res;
            $aclResources[$resourceId]['resourceNs'] = $this->createNamespaceId(
                $res,
                $resources,
                $nsChar
            );
        }

        return $aclResources;
    }

    /**
     * getOrderedResources
     *
     * @param bool $refresh refresh
     *
     * @return array
     */
    public function getOrderedResources($refresh = false)
    {
        $aclResources = array();
        $resources = $this->getAllResources($refresh);

        return $this->orderResources($resources);
    }

    /**
     * createNamespaceId
     *
     * @param AclResource $aclResource
     * @param array       $aclResources
     * @param string      $nsChar
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
     * createNamespaceId
     *
     * @param AclResource $aclResource
     * @param array       $aclResources
     * @param int         $level
     *
     * @return string
     */
    public function createNamespaceLevel(
        AclResource $aclResource,
        $aclResources,
        $level = 0
    ) {
        $parentId = $aclResource->getParentResourceId();
        if (!empty($parentId)) {

            $parent = $aclResources[$parentId];

            $level = $this->createNamespaceLevel(
                $parent,
                $aclResources,
                ($level + 1)
            );
        }

        return $level;
    }

    /**
     * orderResources
     *
     * @param $resources
     *
     * @return array
     */
    public function orderResources($resources)
    {
        $aclResources = array();

        foreach ($resources as $res) {

            $next = $this->orderNext(
                $res,
                $resources
            );

            $aclResources[] = $next;
        }

        return $aclResources;
    }

    /**
     * getOrderNext
     *
     * @param AclResource $aclResource
     * @param             $aclResources
     *
     * @return null
     */
    public function orderNext(
        AclResource $aclResource,
        $aclResources
    ) {
        $parentId = $aclResource->getParentResourceId();

        if (!empty($parentId)) {

            $parent = $aclResources[$parentId];
            return $this->orderNext(
                $parent,
                $aclResources
            );
        }

        return $aclResource;
    }
} 