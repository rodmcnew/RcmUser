<?php
/**
 *
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Resource\ProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class ResourceProvider implements ProviderInterface
{

    protected $resources
        = array(
            'core' => array(
                'read',
                'update',
                'create',
                'delete',

                'pages' => array(
                    'page' => array(),
                ),
            ),
        );

    public function __construct($resources = array())
    {

        $this->resources = array_merge($resources, $this->resources);
    }

    public function setResource($key, $value = array())
    {

        if ($this->resourceExists($key)) {

            throw new \Exception('Duplicate ACL resource not allowed.');
        }

        $this->resources[$key] = $value;
    }


    public function getResource($key, $dflt = array())
    {

        if ($this->resourceExists($key)) {

            return $this->resources[$key];
        }

        return $dflt;
    }

    /**
     * @return \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    public function resourceExists($key)
    {

        if (array_key_exists($key, $this->resources)) {

            return true;
        }

        return false;
    }
}
