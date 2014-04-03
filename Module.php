<?php
/**
 *
 */

namespace RcmUser;

use RcmUser\Config\Config;
use RcmUser\User\Service\UserPropertyService;
use RcmUser\Service\RcmUserService;
use RcmUser\User\Db\DoctrineUserRolesDataMapper;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        // @todo inject what is configurable
        return array(
            'invokables' => array(),
            'factories' => array(
                // Config
                'RcmUser\UserConfig' => function ($sm) {

                        $config = $sm->get('Config');

                        return new Config(isset($config['RcmUser\UserConfig']) ? $config['RcmUser\UserConfig'] : array());
                    },
                'RcmUser\AuthConfig' => function ($sm) {

                        $config = $sm->get('Config');

                        return new Config(isset($config['RcmUser\AuthConfig']) ? $config['RcmUser\AuthConfig'] : array());
                    },
                'RcmUser\AclConfig' => function ($sm) {

                        $config = $sm->get('Config');

                        return new Config(isset($config['RcmUser\AclConfig']) ? $config['RcmUser\AclConfig'] : array());
                    },
                // USER
                'RcmUser\Service\RcmUserService' => function ($sm) {

                        $authServ = $sm->get('RcmUser\Authentication\Service\UserAuthenticationService');
                        $userDataService = $sm->get('RcmUser\User\Service\UserDataService');
                        $userPropertyService = $sm->get('RcmUser\User\Service\UserPropertyService');

                        $service = new RcmUserService();
                        $service->setUserDataService($userDataService);
                        $service->setUserPropertyService($userPropertyService);
                        $service->setUserAuthService($authServ);

                        return $service;
                    },
                'RcmUser\User\Event\Listeners' => function ($sm) {

                        $listeners = array();
                        // User
                        $createUserPreListener = new User\Event\CreateUserPreListener();
                        $listeners[] = $createUserPreListener;

                        $updateUserPreListener = new User\Event\UpdateUserPreListener();
                        $listeners[] = $updateUserPreListener;

                        return $listeners;
                    },

                // ACL
                'RcmUser\Acl\Event\Listeners' => function ($sm) {

                        $cfg = $sm->get('RcmUser\AclConfig');

                        // ACL
                        $aclCreateUserPostListener = new Acl\Event\CreateUserPostListener();
                        $aclCreateUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('DefaultAuthenticatedRoleIdentities', array()));
                        $aclCreateUserPostListener->setUserRolesDataMapper($sm->get('RcmUser\User\UserRolesDataMapper'));
                        $listeners[] = $aclCreateUserPostListener;

                        $aclReadUserPostListener = new Acl\Event\ReadUserPostListener();
                        $aclReadUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('DefaultAuthenticatedRoleIdentities', array()));
                        $aclReadUserPostListener->setUserRolesDataMapper($sm->get('RcmUser\User\UserRolesDataMapper'));
                        $listeners[] = $aclReadUserPostListener;

                        $updateUserPostListener = new Acl\Event\UpdateUserPostListener();
                        $updateUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('DefaultAuthenticatedRoleIdentities', array()));
                        $updateUserPostListener->setUserRolesDataMapper($sm->get('RcmUser\User\UserRolesDataMapper'));
                        $listeners[] = $updateUserPostListener;

                        return $listeners;
                    },
                // Event Aggregation
                'RcmUser\Event\Listeners' => function ($sm) {

                        // Get all events, combine them, return them.
                    },
            ),
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $sm = $application->getServiceManager();
        $eventManager = $application->getEventManager();

        // @todo might create aggregate object
        try {
            $listeners = $sm->get('RcmUser\Event\Listeners');
            foreach ($listeners as $listener) {
                $listener->attach($eventManager);
            }
        } catch (\Exception $e) {
            // no listeners
        }


    }
}
