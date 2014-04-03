<?php
/**
 *
 */

namespace RcmUser;

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

                // Event Aggregation
                'RcmUser\Event\Listeners' => function ($sm) {

                        $listeners = array();
                        return array();
                        $eventListeners = $sm->get('RcmUser\UserConfig')->get('EventListeners', null);

                        if(is_array($eventListeners)){

                            $listeners = array_merge($listeners, $eventListeners);
                        }

                        $eventListeners = $sm->get('RcmUser\AuthConfig')->get('EventListeners', null);

                        if(is_array($eventListeners)){

                            $listeners = array_merge($listeners, $eventListeners);
                        }


                        $eventListeners = $sm->get('RcmUser\AclConfig')->get('EventListeners', null);

                        if(is_array($eventListeners)){

                            $listeners = array_merge($listeners, $eventListeners);
                        }

                        return $listeners;
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
