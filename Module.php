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

        return array(
            'invokables' => array(),
            'factories' => array(

                'RcmUser\Acl\Provider\IdentiyProvider' => function ($sm) {

                        $rcmUserService = $sm->get('RcmUser\Service\RcmUserService');
                        $cfg = $sm->get('RcmUser\Acl\Config');

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
            ),
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
