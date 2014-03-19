<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'RcmUser\Controller\User' => 'RcmUser\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'rcm-user' => array(

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
        'default_role'          => 'guest',
        'authenticated_role'    => 'user',
        'identity_provider' => 'RcmUserServiceIdentiyProviderServiceFactory',
        'role_providers' => array(
            'RcmUser\Acl\Provider\Role\Provider' => array(),
            /*'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array(),
                'user'  => array('children' => array(
                    'admin' => array(),
                )),
            ),*/

        ),
        'resource_providers' => array(
            'RcmUser\Acl\Provider\Resource\Provider' => array(),
            /*'BjyAuthorize\Provider\Resource\Config' => array(
                'pants' => array(),
            ),*/
        ),
        'rule_providers' => array(
            'RcmUser\Acl\Provider\Rule\Provider' => array(),
            /*'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // allow guests and users (and admins, through inheritance)
                    // the "wear" privilege on the resource "pants"
                    array(array('guest', 'user'), 'pants')
                ),

                // Don't mix allow/deny rules if you are using role inheritance.
                // There are some weird bugs.
                'deny' => array(
                    // ...
                ),
            ),*/
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'RcmUserServiceIdentiyProviderServiceFactory' => 'RcmUser\Service\IdentiyProviderServiceFactory',
        ),
    ),
);
