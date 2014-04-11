<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Provider;


use RcmUser\Acl\Provider\ResourceProviderInterface;

class RcmUserAclResourceProvider implements ResourceProviderInterface
{

    /**
     * @var array
     */
    protected $rcmResources = array(
            'user.management' => array(),
            'acl.management' => array(),
        );

    /**
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
     * @return array
     */
    public function getAvailableAtRuntime()
    {

        return $this->getAll();
    }
} 