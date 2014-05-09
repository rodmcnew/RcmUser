<?php
/**
 * BjyResourceProvider.php
 *
 * BjyResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Resource\ProviderInterface;
use RcmUser\Acl\Entity\AclResource;
use RcmUser\Acl\Service\AclResourceService;

/**
 * BjyResourceProvider
 *
 * BjyResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class BjyResourceProvider implements ProviderInterface
{
    /**
     * @var
     */
    protected $rcmUserResourceProvider;

    /**
     * setRcmUserResourceProvider
     *
     * @param AclResourceService $rcmUserResourceProvider rcmUserResourceProvider
     *
     * @return void
     */
    public function setRcmUserResourceProvider(
        AclResourceService $rcmUserResourceProvider
    ) {
        $this->rcmUserResourceProvider = $rcmUserResourceProvider;
    }

    /**
     * getRcmUserResourceProvider
     *
     * @return AclResourceService
     */
    public function getRcmUserResourceProvider()
    {
        return $this->rcmUserResourceProvider;
    }

    /**
     * getResources
     *
     * @return \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources()
    {
        // @todo prep the new version of resources
        $resources = $this->rcmUserResourceProvider->getResources();
        $bjyResources = array();

        foreach($resources as $key => $resource){

            /* @todo could add resources if they are not found */
            if($resource->getParentResourceId()){
                if(!isset($bjyResources[$resource->getParentResourceId()])){

                    $bjyResources[$resource->getParentResourceId()] = new AclResource($resource->getParentResourceId());
                }
            }

            $bjyResources[$resource->getResourceId()] = $resource->getPrivileges();
        }

        return $bjyResources;
    }
}
