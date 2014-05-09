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
     * getResources
     *
     * @param bool $refresh refresh
     *
     * @return array
     */
    public function getResources($refresh = false)
    {

        if (!$this->isCached || $refresh) {

            $this->resources[$this->rootResource->getResourceId()] = $this->rootResource;

            foreach ($this->getResourceProviders() as $providerName => $provider) {

                // easy way
                // array_merge($this->resources, $provider->getAll());

                $providerResources = $provider->getAll();

                foreach($providerResources as $key => $val){

                    // populate if config array
                    if(is_array($val)){

                        $res = new AclResource($val['resourceId']);
                        $res->populate($val);
                    } else {
                        $res = $val;
                    }

                    if($res->getParentResourceId() == null){

                        $res->setParentResourceId($this->rootResource->getResourceId());
                    }

                    $this->resources[$res->getResourceId()] = $res;
                }

            }

            $this->isCached = true;
        }

        return $this->resources;
    }
} 