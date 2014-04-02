<?php
/**
 *
 */

namespace RcmUser;

use RcmUser\Model\Acl\Event\UpdateUserPostListener;
use RcmUser\Model\Acl\Provider\IdentityProvider;
use RcmUser\Model\Authentication\Adapter\RcmUserAdapter;
use RcmUser\Model\Authentication\AuthenticationService;
use RcmUser\Model\Authentication\Storage\RcmUserSession;
use RcmUser\Model\Config\Config;
use RcmUser\Model\User\Db\DoctrineUserDataMapper;
use RcmUser\Model\User\Db\DoctrineUserRolesDataMapper;
use RcmUser\Model\User\Event\ReadUserPreListener;
use RcmUser\Model\User\Event\ReadUserPreListenerTemp;
use RcmUser\Model\User\InputFilter\UserInputFilter;
use RcmUser\Service\RcmUserAuthenticationService;
use RcmUser\Service\RcmUserDataService;
use RcmUser\Service\RcmUserPropertyService;
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
                // GENERAL
                'RcmUser\Model\Config' => function ($sm) {

                        $config = $sm->get('Config');

                        return new Config(isset($config['rcm_user']) ? $config['rcm_user'] : array());
                    },
                // USER
                'RcmUser\Model\User\Db\UserDataMapper' => function ($sm) {

                        $em = $sm->get('Doctrine\ORM\EntityManager');
                        $dm = new DoctrineUserDataMapper();
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
                'RcmUser\Service\RcmUserDataService' => function ($sm) {

                        $dm = $sm->get('RcmUser\Model\User\Db\UserDataMapper');
                        $vs = $sm->get('RcmUser\Service\UserValidatorService');
                        $encrypt = $sm->get('RcmUser\Service\Encryptor');

                        $service = new RcmUserDataService();
                        $service->setEncryptor($encrypt);
                        $service->setUserDataMapper($dm);
                        $service->setUserValidatorService($vs);

                        return $service;
                    },
                'RcmUser\Service\RcmUserAuthenticationService' => function ($sm) {

                        $userDataService = $sm->get('RcmUser\Service\RcmUserDataService');
                        $adapter = new RcmUserAdapter();
                        $adapter->setUserDataService($userDataService);

                        $storage = new RcmUserSession();

                        $auth = new AuthenticationService($storage, $adapter);

                        $service = new RcmUserAuthenticationService();
                        $service->setAuthService($auth);

                        return $service;
                    },
                'RcmUser\Service\RcmUserPropertyService' => function ($sm) {

                        $service = new RcmUserPropertyService();

                        return $service;
                    },
                'RcmUser\Service\RcmUserService' => function ($sm) {

                        $authServ = $sm->get('RcmUser\Service\RcmUserAuthenticationService');
                        $userDataService = $sm->get('RcmUser\Service\RcmUserDataService');
                        $userPropertyService = $sm->get('RcmUser\Service\RcmUserPropertyService');

                        $service = new RcmUserService();
                        $service->setUserDataService($userDataService);
                        $service->setUserPropertyService($userPropertyService);
                        $service->setUserAuthService($authServ);

                        return $service;
                    },

                'RcmUser\Model\Acl\Provider\IdentityProvider' => function ($sm) {

                        $rcmUserService = $sm->get('RcmUser\Service\RcmUserService');
                        $cfg = $sm->get('RcmUser\Model\Config');

                        $service = new IdentityProvider();
                        $service->setUserService($rcmUserService);
                        $service->setDefaultRoleIdentity($cfg->get('aclDefaultRoleIdentities', array()));

                        return $service;
                    },
                'RcmUser\Model\User\Db\UserRolesDataMapper' => function ($sm) {

                        $em = $sm->get('Doctrine\ORM\EntityManager');
                        $dm = new DoctrineUserRolesDataMapper();
                        $dm->setEntityManager($em);
                        $dm->setEntityClass('RcmUser\Model\User\Entity\DoctrineUserRole');

                        return $dm;
                    },

                // EVENT
                'RcmUser\Model\Event\Listeners' => function ($sm) {

                        $cfg = $sm->get('RcmUser\Model\Config');

                        $listeners = array();
                        // User
                        $createUserPreListener = new Model\User\Event\CreateUserPreListener();
                        $listeners[] = $createUserPreListener;

                        $updateUserPreListener = new Model\User\Event\UpdateUserPreListener();
                        $listeners[] = $updateUserPreListener;

                        // ACL
                        $aclCreateUserPostListener = new Model\Acl\Event\CreateUserPostListener();
                        $aclCreateUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('aclDefaultAuthenticatedRoleIdentities', array()));
                        $aclCreateUserPostListener->setUserRolesDataMapper($sm->get('RcmUser\Model\User\Db\UserRolesDataMapper'));
                        $listeners[] = $aclCreateUserPostListener;

                        $aclReadUserPostListener = new Model\Acl\Event\ReadUserPostListener();
                        $aclReadUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('aclDefaultAuthenticatedRoleIdentities', array()));
                        $aclReadUserPostListener->setUserRolesDataMapper($sm->get('RcmUser\Model\User\Db\UserRolesDataMapper'));
                        $listeners[] = $aclReadUserPostListener;

                        $updateUserPostListener = new Model\Acl\Event\UpdateUserPostListener();
                        $updateUserPostListener->setDefaultAuthenticatedRoleIdentities($cfg->get('aclDefaultAuthenticatedRoleIdentities', array()));
                        $updateUserPostListener->setUserRolesDataMapper($sm->get('RcmUser\Model\User\Db\UserRolesDataMapper'));
                        $listeners[] = $updateUserPostListener;

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
            $listeners = $sm->get('RcmUser\Model\Event\Listeners');
            foreach ($listeners as $listener) {
                $listener->attach($eventManager);
            }
        } catch (\Exception $e) {
            // no listeners
        }


    }
}
