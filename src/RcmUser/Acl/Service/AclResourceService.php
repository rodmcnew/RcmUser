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
     * @var string
     */
    protected $rootResource = 'core';
    /**
     * @var array
     */
    protected $rootPrivilege
        = array(
            'read',
            'update',
            'create',
            'delete',
            'execute',
        );

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
     * @param array  $resources     resources
     * @param string $rootResource  rootResource
     * @param null   $rootPrivilege rootPrivilege
     */
    public function __construct(
        $resources = array(),
        $rootResource = 'core',
        $rootPrivilege = null
    ) {

        $this->rootResource = $rootResource;
        if (is_array($rootPrivilege)) {

            $this->rootPrivilege = $rootPrivilege;
        }

        $this->resources[$this->rootResource] = $this->rootPrivilege;

        $this->resources[$this->rootResource] = array_merge(
            $this->resources[$this->rootResource], $resources
        );
    }

    /**
     * getRootPrivilege
     *
     * @return array
     */
    public function getRootPrivilege()
    {
        return $this->rootPrivilege;
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
     * getResources
     *
     * @return array
     */
    public function getResources()
    {
        if (!$this->isCached) {
            foreach ($this->getResourceProviders() as $providerName => $provider) {

                $this->resources[$this->rootResource][$providerName]
                    = $provider->getAll();
            }

            $this->isCached = true;
        }

        return $this->resources;
    }

    /**
     * getRuntimeResources
     *
     * @return array
     */
    public function getRuntimeResources()
    {
        foreach ($this->getResourceProviders() as $providerName => $provider) {

            $this->resources[$this->rootResource][$providerName]
                = $provider->getAvailableAtRuntime();
        }

        return $this->resources;
    }
} 