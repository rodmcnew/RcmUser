<?php
return array(

    'RcmUser\UserConfig' => array(

        'DataMapper' => 'RcmUser\User\Service\Factory\DoctrineUserDataMapper',
        'Encryptor' => 'RcmUser\User\Service\Factory\Encryptor',
        'Encryptor.passwordCost' => 14,
        'InputFilter' => array(

            'username' => array(
                'name' => 'username',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 100,
                        ),
                    ),
                ),
            ),

            'password' => array(
                'name' => 'password',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 100,
                        ),
                    ),
                    /*array(
                        'name' => 'Regex',
                        'options' => array(
                            'pattern' => '^(?=.*\d)(?=.*[a-zA-Z])$'
                        ),
                    ),*/
                ),
            ),
        ),

        'EventListeners' => 'RcmUser\User\Service\Factory\EventListeners',
    ),

    'RcmUser\AuthConfig' => array(

        'Adapter' => '',
        'Storage' => '',
        'AuthService' => '',

        // @todo - config these
        'EventListeners' => null,
    ),

    'RcmUser\AclConfig' => array(

        'RoleDataMapper' => '',
        'UserRolesDataMapper' => '',
        'EventListeners' => array(),

        'DefaultRoleIdentities' => array('guest'),
        'DefaultAuthenticatedRoleIdentities' => array('user'),

        'EventListeners' => 'RcmUser\Acl\Service\Factory\EventListeners',
    ),

    'controllers' => array(
        'invokables' => array(
            'RcmUser\Controller\User' => 'RcmUser\Controller\UserController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'RcmUser' => array(

                'type' => 'segment',
                'options' => array(
                    'route' => '/rcmuser[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'RcmUser\Controller\User',
                        'action' => 'index',
                    ),
                ),
                /*
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/rcm-user',
                    'defaults' => array(
                        //'__NAMESPACE__' => 'RcmUser\Controller',
                        'controller'    => 'RcmUser\Controller\User',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
                */
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'RcmUser' => __DIR__ . '/../view',
        ),
    ),

    'bjyauthorize' => array(
        'default_role' => 'guest',
        'authenticated_role' => 'user',
        'identity_provider' => 'RcmUser\Acl\IdentiyProvider',
        'role_providers' => array(
            'RcmUser\Acl\Provider\RoleProvider' => array(),
        ),
        'resource_providers' => array(
            'RcmUser\Acl\Provider\ResourceProvider' => array(),
        ),
        'rule_providers' => array(
            'RcmUser\Acl\Provider\RuleProvider' => array(),
        ),
    ),

    'service_manager' => array(
        'factories' => array(

            /* REQUIRED */
            'RcmUser\User\UserDataMapper' => 'RcmUser\User\Service\Factory\DoctrineUserDataMapper',
            /**
             * Encryptor
             * Required for:
             * RcmUser\Authentication\Adapter\UserAdapter
             * RcmUser\User\Event\CreateUserPreListener
             * RcmUser\User\Service\UserDataService
             */
            'RcmUser\User\Encryptor' => 'RcmUser\User\Service\Factory\Encryptor',
            /**
             * InputFilter
             * Required for:
             * RcmUser\User\Service
             */
            'RcmUser\User\InputFilter' => 'RcmUser\User\Service\Factory\InputFilter',
            /**
             * UserValidatorService
             * Required for:
             * RcmUser\User\Service\UserDataService
             * RcmUser\User\Event\CreateUserPreListener
             * RcmUser\User\Event\UpdateUserPreListener
             */
            'RcmUser\User\UserValidator' => 'RcmUser\User\Service\Factory\UserValidator',

            /**
             * UserRolesDataMapper
             * Required for (ACL user property):
             * RcmUser\Acl\Event\CreateUserPostListener
             * RcmUser\Acl\Event\DeleteUserPostListener
             * RcmUser\Acl\Event\ReadUserPostListener
             * RcmUser\Acl\Event\UpdateUserPostListener
             */
            'RcmUser\User\UserRolesDataMapper' => 'RcmUser\User\Service\Factory\DoctrineUserRolesDataMapper',

            /**
             * UserAdapter
             * Required for (Auth):
             * RcmUser\Authentication\Service\AuthenticationService
             */
            'RcmUser\Authentication\Adapter' => 'RcmUser\Authentication\Service\Factory\Adapter',
            /**
             * UserSession
             * Required for (Auth):
             * RcmUser\Authentication\Service\AuthenticationService
             */
            'RcmUser\Authentication\Storage' => 'RcmUser\Authentication\Service\Factory\Storage',
            /**
             * UserSession
             * Required for (Auth):
             * RcmUser\Authentication\Service\UserAuthenticationService
             */
            'RcmUser\Authentication\AuthenticationService' => 'RcmUser\Authentication\Service\Factory\AuthenticationService',

            /**
             *
             */
            'RcmUser\Acl\IdentiyProvider' => 'RcmUser\Acl\Service\Factory\IdentiyProvider',

        ),
    ),
);
