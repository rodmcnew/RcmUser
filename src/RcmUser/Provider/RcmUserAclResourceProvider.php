<?php
/**
 * RcmUserAclResourceProvider.php
 *
 * RcmUserAclResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Provider;


use RcmUser\Acl\Provider\ResourceProviderInterface;

/**
 * RcmUserAclResourceProvider
 *
 * RcmUserAclResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserAclResourceProvider implements ResourceProviderInterface
{

    /**
     * @var array
     */
    protected $rcmResources = array(
            'user-management' => array(),
            'acl-management' => array(),
        );

    /**
     * getAll
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources
     *
     * @return array
     */
    public function getAll()
    {

        return $this->rcmResources;
    }


    /**
     * getAvailableAtRuntime
     *
     * @return array|mixed
     */
    public function getAvailableAtRuntime()
    {

        return $this->getAll();
    }
} 