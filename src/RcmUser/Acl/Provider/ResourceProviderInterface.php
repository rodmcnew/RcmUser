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
 * There are multiple methods exposed to allow for greater efficiency
 * If implemented correctly, each method
 * allows only what is required to be returned
 *
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
interface ResourceProviderInterface
{
    /**
     * getResources (ALL resources)
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources including run-time resources
     *
     * @return array
     */
    public function getResources();

    /**
     * getResource
     * Return the requested resource
     * Used to return resources dynamically at run-time
     *
     * @param $resourceId
     *
     * @return array
     */
    public function getResource($resourceId);
} 