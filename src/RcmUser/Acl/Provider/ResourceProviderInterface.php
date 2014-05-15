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
interface ResourceProviderInterface
{
    /**
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources
     *
     * @return array
     */
    public function getAll();

    /**
     * Return a multi-dimensional array of resources and privileges
     * containing a filtered list of resources
     * for example: if you have dynamic resources,
     * you may not want to load these every time there is an acl check,
     * so you have the option to only load them when they are needed
     *
     * @return mixed
     */
    public function getAvailableAtRuntime();
} 