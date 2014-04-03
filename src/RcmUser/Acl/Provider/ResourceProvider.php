<?php
/**
 *
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Resource\ProviderInterface;

/**
 *
 */
class ResourceProvider implements ProviderInterface
{
    /**
     * @return \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources()
    {
        return array(
            'pants' => array('wear'),
        );
    }
}
