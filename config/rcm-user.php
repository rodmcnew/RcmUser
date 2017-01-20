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
                                Zend\Validator\Regex::NOT_MATCH
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
     * Register Zend\EventManager\ListenerAggregateInterface Services
     */
    'EventListener\Config' => [
        // UserAuthenticationServiceListeners
        RcmUser\Authentication\Event\UserAuthenticationServiceListeners::class =>
            RcmUser\Authentication\Event\UserAuthenticationServiceListeners::class,

        // LoggerListeners
        RcmUser\Log\Event\LoggerListeners::class =>
            RcmUser\Log\Event\LoggerListeners::class,

        // UserDataServiceListeners
        RcmUser\User\Event\UserDataServiceListeners::class =>
            RcmUser\User\Event\UserDataServiceListeners::class,

        // UserRoleDataServiceListeners
        RcmUser\User\Event\UserRoleDataServiceListeners::class =>
            RcmUser\User\Event\UserRoleDataServiceListeners::class,
    ],

    /**
     * LoggerListeners Config
     * [{ServiceName} => {Priority}]
     */
    RcmUser\Log\Event\LoggerListeners::class => [
        /* EXAMPLE - Some available logger listeners
        // AclDataService Log Listeners
        RcmUser\Log\Event\AclDataService\CreateAclRoleFailListener::class => 0,
        RcmUser\Log\Event\AclDataService\CreateAclRoleListener::class => 0,
        RcmUser\Log\Event\AclDataService\CreateAclRoleSuccessListener::class => 0,

        RcmUser\Log\Event\AclDataService\CreateAclRuleFailListener::class => 0,
        RcmUser\Log\Event\AclDataService\CreateAclRuleListener::class => 0,
        RcmUser\Log\Event\AclDataService\CreateAclRuleSuccessListener::class => 0,

        RcmUser\Log\Event\AclDataService\DeleteAclRoleFailListener::class => 0,
        RcmUser\Log\Event\AclDataService\DeleteAclRoleListener::class => 0,
        RcmUser\Log\Event\AclDataService\DeleteAclRoleSuccessListener::class => 0,

        RcmUser\Log\Event\AclDataService\DeleteAclRuleFailListener::class => 0,
        RcmUser\Log\Event\AclDataService\DeleteAclRuleListener::class => 0,
        RcmUser\Log\Event\AclDataService\DeleteAclRuleSuccessListener::class => 0,

        // AuthorizeService Log Listeners
        RcmUser\Log\Event\AuthorizeService\IsAllowedErrorListener::class => 0,
        RcmUser\Log\Event\AuthorizeService\IsAllowedFalseListener::class => 0,
        RcmUser\Log\Event\AuthorizeService\IsAllowedSuperAdminListener::class => 0,
        RcmUser\Log\Event\AuthorizeService\IsAllowedTrueListener::class => 0,

        // UserAuthenticationService Log Listeners
        RcmUser\Log\Event\UserAuthenticationService\AuthenticateFailListener::class => 0,
        RcmUser\Log\Event\UserAuthenticationService\ValidateCredentialsFailListener::class => 0,

        // UserDataService Log Listeners
        RcmUser\Log\Event\UserDataService\CreateUserFailListener::class => 0,
        RcmUser\Log\Event\UserDataService\CreateUserListener::class => 0,
        RcmUser\Log\Event\UserDataService\CreateUserSuccessListener::class => 0,

        RcmUser\Log\Event\UserDataService\DeleteUserFailListener::class => 0,
        RcmUser\Log\Event\UserDataService\DeleteUserListener::class => 0,
        RcmUser\Log\Event\UserDataService\DeleteUserSuccessListener::class => 0,

        RcmUser\Log\Event\UserDataService\UpdateUserFailListener::class => 0,
        RcmUser\Log\Event\UserDataService\UpdateUserListener::class => 0,
        RcmUser\Log\Event\UserDataService\UpdateUserSuccessListener::class => 0,

        // UserRoleService Log Listeners
        RcmUser\Log\Event\UserRoleService\AddUserRoleFailListener::class => 0,
        RcmUser\Log\Event\UserRoleService\AddUserRoleListener::class => 0,
        RcmUser\Log\Event\UserRoleService\AddUserRoleSuccessListener::class => 0,

        RcmUser\Log\Event\UserRoleService\CreateUserRolesFailListener::class => 0,
        RcmUser\Log\Event\UserRoleService\CreateUserRolesListener::class => 0,
        RcmUser\Log\Event\UserRoleService\CreateUserRolesSuccessListener::class => 0,

        RcmUser\Log\Event\UserRoleService\DeleteUserRolesFailListener::class => 0,
        RcmUser\Log\Event\UserRoleService\DeleteUserRolesListener::class => 0,
        RcmUser\Log\Event\UserRoleService\DeleteUserRolesSuccessListener::class => 0,

        RcmUser\Log\Event\UserRoleService\RemoveUserRoleFailListener::class => 0,
        RcmUser\Log\Event\UserRoleService\RemoveUserRoleListener::class => 0,
        RcmUser\Log\Event\UserRoleService\RemoveUserRoleSuccessListener::class => 0,

        RcmUser\Log\Event\UserRoleService\UpdateUserRolesFailListener::class => 0,
        RcmUser\Log\Event\UserRoleService\UpdateUserRolesListener::class => 0,
        RcmUser\Log\Event\UserRoleService\UpdateUserRolesSuccessListener::class => 0,
        */
    ]
];
