<?php
/**
 *
 */

namespace RcmUser;

use RcmUser\Model\Config\Config;
use RcmUser\Model\User\Db\DoctrineDataMapper;
use RcmUser\Model\User\InputFilter\UserInputFilter;
use RcmUser\Service\RcmUserService;
use Zend\InputFilter\Factory as InputFactory;
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
                        $dm->setEntityClass('RcmUser\Model\User\Entity\DoctrineUser');

                        return $dm;
                    },
                'RcmUser\Model\User\InputFilter\UserInputFilter' => function ($sm) {

                        $inputFilter = new UserInputFilter();
                        //$inputFilter = new InputFilter();
                        $factory = new InputFactory();
                        $inputs = $sm->get('RcmUser\Model\Config')->get('userInputFilter', array());
                         foreach($inputs as $k => $v){
                             $inputFilter->add($factory->createInput($v), $k);
                         }

                        return $inputFilter;
                    },
                'RcmUser\Service\RcmUserService' => function ($sm) {

                        $dm = $sm->get('RcmUser\Model\User\DataMapper');
                        $cfg = $sm->get('RcmUser\Model\Config');
                        $infi = $sm->get('RcmUser\Model\User\InputFilter\UserInputFilter');
                        $service = new RcmUserService($cfg);
                        $service->setUserDataMapper($dm);
                        $service->setUserInputFilter($infi);

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
