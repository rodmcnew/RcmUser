<?php
/**
 *
 */

namespace RcmUser\Acl\Provider\Resource;

use BjyAuthorize\Provider\Resource\ProviderInterface;

/**
 *
 */
class Provider implements ProviderInterface
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
