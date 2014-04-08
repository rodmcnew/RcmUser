<?php
return array(

    'RcmUser' => array(
        'User\Config' => array(

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
        ),

        'Auth\Config' => array(),

        'Acl\Config' => array(

            'DefaultRoleIdentities' => array('guest'),
            'DefaultAuthenticatedRoleIdentities' => array('user'),
        ),
    ),

    'bjyauthorize' => array(
        'default_role' => 'guest',
        'authenticated_role' => 'user',
        'identity_provider' => 'RcmUser\Acl\Provider\IdentiyProvider',
        'role_providers' => array(
            'RcmUser\Acl\Provider\RoleProvider' => array(),
        ),
        'resource_providers' => array(
            'RcmUser\Acl\Provider\ResourceProvider' => array(
                'RcmUser.Core' => array('create', 'read', 'update', 'delete'),
                'RcmUser.User' => array('create', 'read', 'update', 'delete'),
                'RcmUser.Acl' => array('create', 'read', 'update', 'delete'),
            ),
        ),
        'rule_providers' => array(
            'RcmUser\Acl\Provider\RuleProvider' => array(),
        ),
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

    'service_manager' => array(
        'factories' => array(
            // Config
            'RcmUser\Config' => 'RcmUser\Service\Factory\Config',
            'RcmUser\User\Config' => 'RcmUser\User\Service\Factory\Config',
            'RcmUser\Auth\Config' => 'RcmUser\Authentication\Service\Factory\Config',
            'RcmUser\Acl\Config' => 'RcmUser\Acl\Service\Factory',


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

            'RcmUser\User\UserDataPrep' => 'RcmUser\User\Service\Factory\UserDataPrep',

            /**
             * UserValidatorService
             * Required for:
             * RcmUser\User\Service\UserDataService
             * RcmUser\User\Service\Factory\EventListeners
             * RcmUser\User\Event\CreateUserPreListener
             * RcmUser\User\Event\UpdateUserPreListener
             */
            'RcmUser\User\UserValidator' => 'RcmUser\User\Service\Factory\UserValidator',

            /**
             * UserRolesDataMapper
             * Required for (ACL user property):
             * RcmUser\Acl\Service\Factory\EventListeners
             * RcmUser\Acl\Event\CreateUserPostListener
             * RcmUser\Acl\Event\DeleteUserPostListener
             * RcmUser\Acl\Event\ReadUserPostListener
             * RcmUser\Acl\Event\UpdateUserPostListener
             */
            'RcmUser\User\UserRolesDataMapper' => 'RcmUser\User\Service\Factory\DoctrineUserRolesDataMapper',

            /**
             * EventListeners
             * Required for (User validation and input filtering):
             */
            'RcmUser\User\EventListeners' => 'RcmUser\User\Service\Factory\EventListeners',

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
            //'RcmUser\Authentication\EventListeners' => 'RcmUser\Authentication\Service\Factory\EventListeners',

            /**
             * IdentiyProvider
             * Required for BjyAuthorize:
             */
            'RcmUser\Acl\IdentiyProvider' => 'RcmUser\Acl\Service\Factory\IdentiyProvider',

            /**
             * EventListeners
             * Required for (User Property populating):
             */
            'RcmUser\Acl\EventListeners' => 'RcmUser\Acl\Service\Factory\EventListeners',

            // ****REQUIRED****
            'RcmUser\User\Service\UserPropertyService' => 'RcmUser\User\Service\Factory\UserPropertyService',
            'RcmUser\User\Service\UserDataPrepService' => 'RcmUser\User\Service\Factory\UserDataPrep',
            'RcmUser\User\Service\UserValidatorService' => 'RcmUser\User\Service\Factory\UserValidator',
            'RcmUser\User\Service\UserDataService' => 'RcmUser\User\Service\Factory\UserDataService',
            'RcmUser\Authentication\Service\UserAuthenticationService' => 'RcmUser\Authentication\Service\Factory\UserAuthenticationService',
            'RcmUser\Service\RcmUserService' => 'RcmUser\Service\Factory\RcmUserService',

            // Event Aggregation
            'RcmUser\Event\Listeners' => 'RcmUser\Service\Factory\EventListeners',
        ),
    ),
);
