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

use RcmUser\Exception\RcmUserException;


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
     * @var array $resources
     */
    protected $resources = array();

    /**
     * __construct
     *
     * @param array  $resources  resources
     */
    public function __construct($resources)
    {
        if (is_array($resources)) {
            $this->resources = $resources;
        }
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
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function getResource($resourceId)
    {
        if (isset($this->resources[$resourceId])) {

            return $this->resources[$resourceId];
        }

        throw new RcmUserException('Resource Id (key) ' . $resourceId . ' not found in resources array.');
    }
} 