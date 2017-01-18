<?php
/**
 * rcm-user.php
 */
return [
    'User\Config' => [
        /*
         * ValidUserStates
         * Used for UI
         */
        'ValidUserStates' => [
            'disabled',
            // **REQUIRED for User entity**
            'enabled',
        ],

        /*
         * DefaultUserState
         * Used in:
         *  RcmUser\User\Service\UserDataService
         *
         * This is the default user state that will
         * be set on create/update if none is set.
         */
        'DefaultUserState' => 'enabled',

        /*
         * Encryptor.passwordCost
         * Used in:
         *  RcmUser\User\Encryptor
         *
         * This should only be changed if you know what you are doing.
         */
        'Encryptor.passwordCost' => 14,

        /*
         * InputFilter
         * Used in:
         *  RcmUser\User\Db\UserDataMapper
         *
         * This input filter will be applied
         * to the User object on create and save.
         */
        'InputFilter' => [

            'username' => [
                'name' => 'username',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 100,
                        ],
                    ],
                    // Help protect from XSS
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => "/^[a-zA-Z0-9-_@'.]+$/",
                            //'pattern' => "/[<>]/",
                            'messageTemplates' => [
                                \Zend\Validator\Regex::NOT_MATCH
                                => "Username can only contain letters, numbers and charactors: . - _ @ '."
                            ]
                        ],
                    ],
                ],
            ],
            'password' => [
                'name' => 'password',
                'required' => true,
                'filters' => [],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 100,
                        ],
                    ],
                    /*
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '^(?=.*\d](?=.*[a-zA-Z]]$'
                        ],
                    ],
                    */
                ],
            ],
            'email' => [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => 'Zend\Filter\StripTags'],
                    // Help protect from XSS
                    ['name' => 'Zend\Filter\StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Zend\Validator\EmailAddress'],
                ],
            ],
            'name' => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    ['name' => 'Zend\Filter\StripTags'],
                    // Help protect from XSS
                    ['name' => 'Zend\Filter\StringTrim'],
                ],
                'validators' => [],
            ],
        ],
    ],
    'Auth\Config' => [
        'ObfuscatePasswordOnAuth' => true,
    ],
    'Acl\Config' => [
        /*
         * DefaultGuestRoleIds and DefaultUserRoleIds
         * Used by:
         *  RcmUser\Acl\EventListeners
         *
         * These event listeners inject the ACL roles property
         * for a user on the user data events
         * in RcmUser\User\Service\UserDataService.
         */
        'DefaultGuestRoleIds' => ['guest'],
        'DefaultUserRoleIds' => ['user'],

        /*
         * SuperAdminRoleId
         *
         * If this is set, this role will get full permissions always
         * Basically over-rides standard permission handling
         */
        'SuperAdminRoleId' => 'admin',

        /**
         * @todo work this out
         */
        'GuestRoleId' => 'guest',

        /*
         * ResourceProviders
         * Used in:
         *  RcmUser\Acl\Service\AclResourceService
         *
         * This aggregates resources that may be injected by any module,
         * this module wraps the resources
         * in a root resource with common privileges.
         *
         * IMPORTANT:
         * - Parent resources must be first in the resource array
         * - It is not possible to share parent or child resources
         *   between different providers
         *
         * Format for each value of this array is:
         *
         * 'ProviderId(module namespace without back-slashes]' =>
         * 'MyResource/ResourceProvider(extents ResourceProvider]'
         *
         * OR
         *
         * ProviderId(usually module namespace]' => [
         *     'resourceId' => 'some-resource'
         *     'parentResourceId' => null // Or a parent resourceId if needed
         *     'privileges' => ['privilege1', 'privilege2', 'etc...'],
         *     'name' => 'Human readable or translatable name',
         *     'description' => 'Human readable or translatable description',
         * ]
         */
        'ResourceProviders' => [
            /**
             * Root Resource Provider
             */
            'root' => RcmUser\Acl\Provider\RootResourceProvider::class,

            /*
             * RcmUserAccess
             * This module inject some of this module's resources.
             * Also example of a Resource provider
             */
            'RcmUser' => RcmUser\Provider\RcmUserAclResourceProvider::class,

            /* example of resource providers as array *
            'RcmUser' => [
                'test-one' => [
                    'resourceId' => 'test-one',
                    'parentResourceId' => null,
                    'privileges' => [
                        'read',
                        'update',
                        'create',
                        'delete',
                        'execute',
                    ],
                    'name' => 'Test resource one.',
                    'description' => 'test resource one desc.',
                ],
                'test-two' => [
                    'resourceId' => 'test-two',
                    'parentResourceId' => 'test-one',
                    'privileges' => [
                        'read',
                        'update',
                        'create',
                        'delete',
                        'execute',
                    ],
                    'name' => 'Test resource two.',
                    'description' => 'test resource two desc.',
                ]
            ],
            /* - example */
        ],
    ],
    /**
     * Register \Zend\EventManager\ListenerAggregateInterface Services
     */
    'EventListener\Config' => [
        // UserDataServiceListeners
        RcmUser\User\Event\UserDataServiceListeners::class
        => RcmUser\User\Event\UserDataServiceListeners::class,
        // UserAuthenticationServiceListeners
        RcmUser\Authentication\Event\UserAuthenticationServiceListeners::class
        => RcmUser\Authentication\Event\UserAuthenticationServiceListeners::class,
        // UserRoleDataServiceListeners
        RcmUser\User\Event\UserRoleDataServiceListeners::class
        => RcmUser\User\Event\UserRoleDataServiceListeners::class,
    ],

    RcmUser\Log\Event\LoggerListeners::class => [

    ]
];
