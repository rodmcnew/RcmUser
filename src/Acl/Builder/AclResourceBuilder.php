<?php

namespace RcmUser\Acl\Builder;

use RcmUser\Acl\Entity\AclResource;
use RcmUser\Exception\RcmUserException;

/**
 * Class AclResourceBuilder
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   AclResource
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclResourceBuilder
{
    /**
     * @var \RcmUser\Acl\Entity\AclResource
     */
    protected $rootResource;

    /**
     * AclResourceBuilder constructor.
     *
     * @param AclResource $rootResource
     */
    public function __construct(
        AclResource $rootResource
    ) {
        $this->rootResource = $rootResource;
    }

    /**
     * getRootResourceId
     *
     * @return string
     */
    protected function getRootResourceId() {
        return $this->rootResource->getResourceId();
    }

    /**
     * build
     *
     * @param mixed  $resourceData
     * @param string $providerId
     *
     * @return \RcmUser\Acl\Entity\AclResource
     * @throws RcmUserException
     */
    public function build(
        $resourceData,
        $providerId
    ) {
        $resource = null;

        if ($resourceData instanceof \RcmUser\Acl\Entity\AclResource) {
            $resource = $resourceData;
        }

        if (is_array($resourceData)) {
            $resource = new \RcmUser\Acl\Entity\AclResource(
                $resourceData['resourceId']
            );
            $resource->populate($resourceData);
        }

        if ($resource === null) {
            throw new RcmUserException(
                'Resource is not valid: ' . var_export(
                    $resourceData,
                    true
                )
            );
        }

        $resourceProviderId = $resource->getProviderId();

        if (empty($resourceProviderId)) {
            $resource->setProviderId($providerId);
        }

        $resource = $this->buildParent($resource);

        return $resource;
    }

    /**
     * buildParent
     *
     * @param AclResource $resource
     *
     * @return AclResource
     * @throws RcmUserException
     */
    public function buildParent(AclResource $resource)
    {
        $parentResourceId = $resource->getParentResourceId();

        if (empty($parentResourceId)) {
            $resource->setParentResourceId(
                $this->getRootResourceId()
            );
        }

        return $resource;
    }
}
