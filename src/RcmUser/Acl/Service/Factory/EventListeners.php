<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Service\Factory;

use RcmUser\Acl\Event\CreateUserPostListener;
use RcmUser\Acl\Event\DeleteUserPostListener;
use RcmUser\Acl\Event\ReadUserPostListener;
use RcmUser\Acl\Event\UpdateUserPostListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventListeners implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $cfg = $serviceLocator->get('RcmUser\AclConfig');

        // ACL
        $createUserPostListener = new CreateUserPostListener();
        $createUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('DefaultAuthenticatedRoleIdentities', array()));
        $createUserPostListener->setUserRolesDataMapper($serviceLocator->get('RcmUser\User\UserRolesDataMapper'));
        $listeners[] = $createUserPostListener;

        $readUserPostListener = new ReadUserPostListener();
        $readUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('DefaultAuthenticatedRoleIdentities', array()));
        $readUserPostListener->setUserRolesDataMapper($serviceLocator->get('RcmUser\User\UserRolesDataMapper'));
        $listeners[] = $readUserPostListener;

        $updateUserPostListener = new UpdateUserPostListener();
        $updateUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('DefaultAuthenticatedRoleIdentities', array()));
        $updateUserPostListener->setUserRolesDataMapper($serviceLocator->get('RcmUser\User\UserRolesDataMapper'));
        $listeners[] = $updateUserPostListener;

        $deleteUserPostListener = new DeleteUserPostListener();
        $deleteUserPostListener->setDefaultRoleIdentities($cfg->get('DefaultRoleIdentities', array()));
        //$deleteUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('DefaultAuthenticatedRoleIdentities', array()));
        $deleteUserPostListener->setUserRolesDataMapper($serviceLocator->get('RcmUser\User\UserRolesDataMapper'));
        $listeners[] = $deleteUserPostListener;

        return $listeners;
    }
}