<?php
/**
 *
 */

namespace RcmUser;

use RcmUser\Model\Authentication\Adapter\RcmUserAdapter;
use RcmUser\Model\Authentication\Storage\RcmUserSession;
use RcmUser\Model\Config\Config;
use RcmUser\Model\User\Db\DoctrineDataMapper;
use RcmUser\Model\User\InputFilter\UserInputFilter;
use RcmUser\Service\RcmUserAuthenticationService;
use RcmUser\Service\RcmUserService;
use RcmUser\Service\UserValidatorService;
use Zend\Crypt\Password\Bcrypt;
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
        // @todo inject what is configurable
        return array(
            'invokables' => array(),
            'factories' => array(

                'RcmUser\Model\Config' => function ($sm) {

                        $config = $sm->get('Config');

                        return new Config(isset($config['rcm_user']) ? $config['rcm_user'] : array());
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
                        $factory = new InputFactory();
                        $inputs = $sm->get('RcmUser\Model\Config')->get('userInputFilter', array());
                        foreach ($inputs as $k => $v) {
                            $inputFilter->add($factory->createInput($v), $k);
                        }

                        return $inputFilter;
                    },
                'RcmUser\Service\Encryptor' => function ($sm) {

                        $cfg = $sm->get('RcmUser\Model\Config');
                        $encryptor = new Bcrypt();
                        $encryptor->setCost($cfg->get('passwordCost', 14));

                        return $encryptor;
                    },
                'RcmUser\Service\UserValidatorService' => function ($sm) {

                        $infi = $sm->get('RcmUser\Model\User\InputFilter\UserInputFilter');
                        $service = new UserValidatorService($infi);

                        return $service;
                    },
                'RcmUser\Service\RcmUserAuthenticationService' => function ($sm) {

                        $encrypt = $sm->get('RcmUser\Service\Encryptor');
                        $dm = $sm->get('RcmUser\Model\User\DataMapper');

                        $adapter = new RcmUserAdapter();
                        $adapter->setEncryptor($encrypt);
                        $adapter->setUserDataMapper($dm);

                        //$storage = $sm->get('rcmSessionMgr')->getStorage();
                        $storage = new RcmUserSession();

                        $service = new RcmUserAuthenticationService($storage, $adapter);

                        return $service;
                    },
                'RcmUser\Service\RcmUserService' => function ($sm) {

                        $dm = $sm->get('RcmUser\Model\User\DataMapper');
                        $cfg = $sm->get('RcmUser\Model\Config');
                        $vs = $sm->get('RcmUser\Service\UserValidatorService');
                        $authServ = $sm->get('RcmUser\Service\RcmUserAuthenticationService');
                        $encrypt = $sm->get('RcmUser\Service\Encryptor');

                        $service = new RcmUserService($cfg);
                        $service->setUserDataMapper($dm);
                        $service->setUserValidatorService($vs);
                        $service->setAuthService($authServ);
                        $service->setEncryptor($encrypt);

                        return $service;
                    },
            ),
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        // @todo inject these
        $eventManager = $event->getApplication()->getEventManager();

        $createUserPreListener = new Model\User\Event\CreateUserPreListener();
        $createUserPreListener->attach($eventManager);

        $updateUserPreListener = new Model\User\Event\UpdateUserPreListener();
        $updateUserPreListener->attach($eventManager);
    }
}
