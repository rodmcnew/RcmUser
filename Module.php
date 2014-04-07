<?php
/**
 *
 */

namespace RcmUser;

use RcmUser\Acl\Provider\IdentityProvider;
use RcmUser\Acl\Provider\ResourceProvider;
use RcmUser\Acl\Provider\RoleProvider;
use RcmUser\Acl\Provider\RuleProvider;
use RcmUser\Acl\Service\Factory\IdentiyProvider;
use RcmUser\Config\Config;
use RcmUser\Service\RcmUserService;
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

        $factories = array(
            // Config
            'RcmUser\Config' => function ($sm) {

                    $config = $sm->get('Config');

                    $rcmConfig = isset($config['RcmUser']) ? $config['RcmUser'] : array();

                    return $rcmConfig;
                },
            'RcmUser\UserConfig' => function ($sm) {

                    $config = $sm->get('RcmUser\Config');

                    return new Config(isset($config['UserConfig']) ? $config['UserConfig'] : array());
                },
            'RcmUser\AuthConfig' => function ($sm) {

                    $config = $sm->get('RcmUser\Config');

                    return new Config(isset($config['AuthConfig']) ? $config['AuthConfig'] : array());
                },
            'RcmUser\AclConfig' => function ($sm) {

                    $config = $sm->get('RcmUser\Config');

                    return new Config(isset($config['AclConfig']) ? $config['AclConfig'] : array());
                },
            // ****REQUIRED****
            'RcmUser\User\Service\UserPropertyService' => 'RcmUser\User\Service\Factory\UserPropertyService',
            'RcmUser\User\Service\UserDataService' => 'RcmUser\User\Service\Factory\UserDataService',
            'RcmUser\Authentication\Service\UserAuthenticationService' => 'RcmUser\Authentication\Service\Factory\UserAuthenticationService',
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



            'RcmUser\Acl\Provider\IdentiyProvider' => function ($sm) {

                    $rcmUserService = $sm->get('RcmUser\Service\RcmUserService');
                    $cfg = $sm->get('RcmUser\AclConfig');

                    $service = new IdentityProvider();
                    $service->setUserService($rcmUserService);
                    $service->setDefaultRoleIdentity($cfg->get('DefaultRoleIdentities', array()));

                    return $service;
                },

            'RcmUser\Acl\Provider\RoleProvider' => function ($sm) {

                    $service = new RoleProvider();
                    return $service;
                },
            'RcmUser\Acl\Provider\RuleProvider' => function ($sm) {

                    $service = new RuleProvider();
                    return $service;
                },
            'RcmUser\Acl\Provider\ResourceProvider' => function ($sm) {

                    $service = new ResourceProvider();
                    return $service;
                },
            // Event Aggregation
            'RcmUser\Event\Listeners' => function ($sm) {

                    $listeners = array();
                    $config = $sm->get('Config');

                    try {
                        $eventListeners = $sm->get('RcmUser\User\EventListeners');
                        $listeners = $eventListeners;
                    } catch (\Exception $e) {
                        // no listeners
                    }

                    try {
                        $eventListeners = $sm->get('RcmUser\Authentication\EventListeners');
                        $listeners = array_merge($eventListeners, $listeners);
                    } catch (\Exception $e) {
                        // no listeners
                    }

                    try {
                        $eventListeners = $sm->get('RcmUser\Acl\EventListeners');
                        $listeners = array_merge($eventListeners, $listeners);
                    } catch (\Exception $e) {
                        // no listeners
                    }

                    return $listeners;
                },

        );

        // @todo this is not required, can be moved to module=>factory?
        $moduleConfig = $this->getConfig();

        $rcmConfig = isset($moduleConfig['RcmUser']) ? $moduleConfig['RcmUser'] : array();

        $factoryConfig = isset($rcmConfig['Factories']) ? $rcmConfig['Factories'] : array();

        $factories = array_merge($factoryConfig, $factories);

        // Actual
        return array(
            'invokables' => array(),
            'factories' => $factories,
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $sm = $application->getServiceManager();
        $eventManager = $application->getEventManager();

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
