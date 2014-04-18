<?php
/**
 * BjyResourceProvider.php
 *
 * BjyResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Resource\ProviderInterface;
use RcmUser\Acl\Service\AclResourceService;

/**
 * BjyResourceProvider
 *
 * BjyResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class BjyResourceProvider implements ProviderInterface
{
    /**
     * @var
     */
    protected $rcmUserResourceProvider;

    /**
     * setRcmUserResourceProvider
     *
     * @param AclResourceService $rcmUserResourceProvider rcmUserResourceProvider
     *
     * @return void
     */
    public function setRcmUserResourceProvider(
        AclResourceService $rcmUserResourceProvider
    ) {
        $this->rcmUserResourceProvider = $rcmUserResourceProvider;
    }

    /**
     * getRcmUserResourceProvider
     *
     * @return AclResourceService
     */
    public function getRcmUserResourceProvider()
    {
        return $this->rcmUserResourceProvider;
    }

    /**
     * getResources
     *
     * @return \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources()
    {
        return $this->rcmUserResourceProvider->getResources();
    }
}
