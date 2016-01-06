<?php

namespace RcmUser\Acl\Builder;

use RcmUser\Acl\Entity\AclResource;
use RcmUser\Acl\Provider\ResourceProviderInterface;
use RcmUser\Exception\RcmUserException;

/**
 * Class AclResourceStackBuilder
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
class AclResourceStackBuilder
{
    /**
     * @var int $maxResourceNesting
     */
    protected $maxResourceNesting = 10;

    /**
     * build
     *
     * @param ResourceProviderInterface $provider
     * @param AclResource               $resource
     *
     * @return array
     * @throws RcmUserException
     */
    public function build(
        ResourceProviderInterface $provider,
        AclResource $resource
    ) {
        return $this->getResourceStack($provider, $resource);
    }

    /**
     * getResourceStack
     *
     * @param ResourceProviderInterface $provider
     * @param AclResource               $resource
     * @param array                     $resources
     * @param int                       $nestLevel
     *
     * @return array
     * @throws RcmUserException
     */
    public function getResourceStack(
        ResourceProviderInterface $provider,
        AclResource $resource,
        &$resources = [],
        $nestLevel = 0
    ) {
        if ($nestLevel > $this->maxResourceNesting) {
            throw new RcmUserException(
                'Max resource nesting exceeded, max nesting level is '
                . $this->maxResourceNesting
            );
        }

        $tempResource = [$resource->getResourceId() => $resource];
        $resources = $tempResource + $resources;

        $parentResourceId = $resource->getParentResourceId();

        $hasParent = ($parentResourceId !== null);

        if ($hasParent) {
            $parentResource = $provider->getResource($parentResourceId);

            $nestLevel ++;
            return $this->getResourceStack(
                $provider,
                $parentResource,
                $resources,
                $nestLevel
            );
        }

        return $resources;
    }
}
