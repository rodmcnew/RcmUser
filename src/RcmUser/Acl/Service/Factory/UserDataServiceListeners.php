<?php
/**
 * UserDataServiceListeners.php
 *
 * UserDataServiceListeners
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

use RcmUser\Acl\Event\CreateUserPostListener;
use RcmUser\Acl\Event\DeleteUserPostListener;
use RcmUser\Acl\Event\ReadUserPostListener;
use RcmUser\Acl\Event\UpdateUserPostListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * UserDataServiceListeners
 *
 * UserDataServiceListeners Factory
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
class UserDataServiceListeners implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return array
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $cfg = $serviceLocator->get('RcmUser\Acl\Config');

        // ACL
        $service
            = new \RcmUser\Acl\Event\UserDataServiceListeners();

        $service->setDefaultAuthenticatedRoleIdentities(
            $cfg->get('DefaultAuthenticatedRoleIdentities', array())
        );

        $service->setDefaultRoleIdentities(
            $cfg->get('DefaultRoleIdentities', array())
        );

        $service->setUserRolesDataMapper(
            $serviceLocator->get('RcmUser\User\UserRolesDataMapper')
        );

        return $service;
    }
}