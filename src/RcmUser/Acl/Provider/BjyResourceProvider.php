<?php
/**
 *
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Resource\ProviderInterface;
use RcmUser\Acl\Service\AclResourceService;

/**
 *
 */
class BjyResourceProvider implements ProviderInterface
{
    protected $rcmUserResourceProvider;

    /**
     * @param AclResourceService $rcmUserResourceProvider
     */
    public function setRcmUserResourceProvider(AclResourceService $rcmUserResourceProvider)
    {
        $this->rcmUserResourceProvider = $rcmUserResourceProvider;
    }

    /**
     * @return AclResourceService
     */
    public function getRcmUserResourceProvider()
    {
        return $this->rcmUserResourceProvider;
    }

    /**
     * @return \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources()
    {
        return $this->rcmUserResourceProvider->getResources();
    }
}
