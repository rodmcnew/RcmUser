<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Service;


use BjyAuthorize\Service\Authorize;
use Zend\Permissions\Acl\Exception\InvalidArgumentException;

class BjyAuthorizeService extends Authorize
{
    const RESOURCE_DELIMITER = '.';

    public function isAllowed($resource, $privilege = null, $user = null)
    {
        $this->loaded && $this->loaded->__invoke();

        if(!empty($user)){

            // @todo implement this if possible. NOTE: BJY is doing something here that my not allow for direct checking of this.
            throw new \Exception('Checking ACL->isAllowed on user object directly is not yet supported.');
        }

        $resources = $this->parseResource($resource);

        foreach ($resources as $res) {

            try {

                return $this->acl->isAllowed($this->getIdentity(), $res, $privilege);

            } catch (InvalidArgumentException $e) {
                // do nothing
            }
        }

        return false;
    }


    public function parseResource($resource)
    {
        if (is_string($resource)) {

            $resources = explode(self::RESOURCE_DELIMITER, $resource);

            $resources = array_reverse($resources);

            return $resources;
        }

        return array($resource);
    }
} 