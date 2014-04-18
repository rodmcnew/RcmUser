<?php
/**
 * UserAuthorizeService.php
 *
 * UserAuthorizeService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Service;


use BjyAuthorize\Service\Authorize;
use Zend\Permissions\Acl\Exception\InvalidArgumentException;

/**
 * UserAuthorizeService
 *
 * UserAuthorizeService for ACL
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserAuthorizeService extends Authorize
{
    /**
     *
     */
    const RESOURCE_DELIMITER = '.';

    /**
     * isAllowed
     *
     * @param string|\Zend\Permissions\Acl\Resource\ResourceInterface $resource  resource
     * @param null                                                    $privilege privilege
     * @param null                                                    $user      user
     *
     * @return bool
     * @throws \Exception
     */
    public function isAllowed($resource, $privilege = null, $user = null)
    {
        $this->loaded && $this->loaded->__invoke();

        if (!empty($user)) {

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


    /**
     * parseResource
     *
     * @param string $resource resource
     *
     * @return array
     */
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