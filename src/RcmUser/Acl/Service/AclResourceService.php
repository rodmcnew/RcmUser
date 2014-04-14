<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Service;


class AclResourceService
{

    protected $rootResource = 'core';
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

    protected $resources = array();

    private $isCached = false;

    public function __construct($resources = array(), $rootResource = 'core', $rootPrivilege = null)
    {

        $this->rootResource = $rootResource;
        if (is_array($rootPrivilege)) {

            $this->rootPrivilege = $rootPrivilege;
        }

        $this->resources[$this->rootResource] = $this->rootPrivilege;

        $this->resources[$this->rootResource] = array_merge($this->resources[$this->rootResource], $resources);
    }

    /**
     * @param array $resourceProviders
     */
    public function setResourceProviders($resourceProviders)
    {
        $this->resourceProviders = $resourceProviders;
    }

    /**
     * @return array
     */
    public function getResourceProviders()
    {
        return $this->resourceProviders;
    }

    /**
     * @return \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources()
    {
        //var_dump($this->resources);
        if (!$this->isCached) {
            foreach ($this->getResourceProviders() as $providerName => $provider) {

                $this->resources[$this->rootResource][$providerName] = $provider->getAll();
            }
        }

        return $this->resources;
    }

    public function getRuntimeResources()
    {
        //@todo Implement this
        return $this->getResources();
    }
} 