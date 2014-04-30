<?php
/**
 * BjyIdentityProvider.php
 *
 * BjyIdentityProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * BjyIdentityProvider
 *
 * BjyIdentityProvider Factory
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class BjyIdentityProvider implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Acl\Provider\BjyIdentityProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $rcmUserService = $serviceLocator->get('RcmUser\Service\RcmUserService');
        $cfg = $serviceLocator->get('RcmUser\Acl\Config');

        $service = new \RcmUser\Acl\Provider\BjyIdentityProvider();
        $service->setUserService($rcmUserService);
        $service->setDefaultRoleIdentities(
            $cfg->get('DefaultRoleIdentities', array())
        );

        return $service;
    }
}