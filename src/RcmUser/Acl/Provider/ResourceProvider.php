<?php
/**
 * ResourceProviderInterface.php
 *
 * ResourceProviderInterface
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


/**
 * Interface ResourceProviderInterface
 *
 * ResourceProviderInterface Interface
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
class ResourceProvider implements ResourceProviderInterface
{
    /**
     * @var string $providerId
     */
    protected $providerId = null;

    /**
     * @var array $resources
     */
    protected $resources = array();

    /**
     * __construct
     *
     * @param string $providerId providerId
     * @param array  $resources  resources
     */
    public function __construct($providerId, $resources)
    {
        $this->providerId = (string) $providerId;

        if (is_array($resources)) {
            $this->resources = $resources;
        }
    }

    /**
     * getProviderId - Provide a unique id for you provider (usually the Module name)
     * Allows for finding resources for specific provider
     *
     * @return string
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * getResources
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources
     *
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * getResource
     * Return the requested resource
     * Can be used to return resources dynamically.
     *
     * @param $resourceId
     *
     * @return array
     */
    public function getResource($resourceId)
    {
        if(isset($resources[$resourceId])){

            return $resources[$resourceId];
        }

        return null;
    }
} 