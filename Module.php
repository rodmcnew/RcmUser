<?php
/**
 *
 */

namespace RcmUser;

use RcmUser\Model\Config\Config;
use RcmUser\Model\User\Db\DoctrineDataMapper;
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

                'RcmUser\Model\Config' => function ($sm) {
                        $config = $sm->get('Config');

                        return new Config(isset($config['rcm_user']) ? $config['rcm_user'] : array());
                    },
                'RcmUser\Model\User\Container' => function ($sm) {

                        return new Container('rcm_user');
                    },
                'RcmUser\Model\User\DataMapper' => function ($sm) {

                        $em = $sm->get('Doctrine\ORM\EntityManager');
                        $dm = new DoctrineDataMapper();
                        $dm->setEntityManager($em);
                        $dm->setEntityClass('RcmUser\Model\User\Entity');
                        return $dm;
                    },
                'RcmUser\Service\RcmUserService' => function ($sm) {

                        $dm = $sm->get('RcmUser\Model\User\DataMapper');
                        $cfg = $sm->get('RcmUser\Model\Config');
                        $service = new RcmUserService($cfg);
                        return $service;
                    },
            ),
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        //$eventManager        = $e->getApplication()->getEventManager();
        //$moduleRouteListener = new ModuleRouteListener();
        //$moduleRouteListener->attach($eventManager);

        /*
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        !
        $sharedEventManager->attach(
            'RcmUser\Service\RcmUserService', 'sendTweet', function ($e) {
                var_dump($e);
            }, 100
        );
        */
    }
}
