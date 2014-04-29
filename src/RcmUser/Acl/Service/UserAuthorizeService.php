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
class UserAuthorizeService
{
    /**
     *
     */
    const RESOURCE_DELIMITER = '.';

    /**
     * @var Authorize
     */
    protected $authorize;

    /**
     * @param mixed $authorize
     */
    public function setAuthorize($authorize)
    {
        $this->authorize = $authorize;
    }

    /**
     * @return mixed
     */
    public function getAuthorize()
    {
        return $this->authorize;
    }

    /**
     * isAllowed
     *
     * @param string|ResourceInterface $resource  resource
     * @param null                     $privilege privilege
     * @param null                     $user      user (not supported)
     *
     * @return bool
     * @throws \Exception
     */
    public function isAllowed($resource, $privilege = null, $user = null)
    {
        $this->loaded && $this->loaded->__invoke();

        if (!empty($user)) {

            // @todo implement this if possible.
            // NOTE: BJY is doing something here that may not allow
            // for direct checking of this.
            throw new \Exception(
                'Checking ACL->isAllowed '.
                'on user object directly is not yet supported.'
            );
        }

        // check once before parsing
        $result = $this->authorize->isAllowed($resource, $privilege);

        if($result){
            return $result;
        }

        $resources = $this->parseResource($resource);

        foreach ($resources as $res) {

            $result = $this->authorize->isAllowed($res, $privilege);

            if($result){
                return $result;
            }
        }

        return false;
    }

    /**
     * parseResource
     * This allows use to parse our dot notation for nested resources
     * which is used when a missing resource can inherit.
     *
     * To do this we need to provide the resource and its parent.
     * We accomplish this by passing 'PAGES.PAGE_X'.
     * Our isAllowed override allows the checking of 'PAGE_X' first and
     * if it is not found, we check 'PAGES'.
     *
     * Example:
     *  If a resource called 'PAGES'
     *  And we want to check if the user has access
     * to a child of 'PAGES' named 'PAGE_X'.
     *  And we know at the time of the ACL check
     * that 'PAGE_X' might not be defined.
     *  If 'PAGE_X' is not defined, then we inherit from from 'PAGES'
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