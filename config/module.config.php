<?php
/**
 * module.config.php
 *
 * Module configuration
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */
return [
    'RcmUser' => [
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

                /*
                 * RcmUserAccess
                 * This module inject some of this module's resources.
                 * Also example of a Resource provider
                 */
                'RcmUser' => 'RcmUser\Provider\RcmUserAclResourceProvider',

                /* example of resource providers as array *
                'RcmUser.TEST' => [
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
    ],
    'service_manager' => [
        'factories' => [
            /*
             * Config
             */
            'RcmUser\Config' => 'RcmUser\Service\Factory\Config',
            'RcmUser\User\Config' => 'RcmUser\User\Service\Factory\Config',
            'RcmUser\Auth\Config' => 'RcmUser\Authentication\Service\Factory\Config',
            'RcmUser\Acl\Config' => 'RcmUser\Acl\Service\Factory\Config',
            /* ************************************** */
            /* USER ********************************* */
            /* ************************************** */

            /*
             * UserDataService - Core User data access service
             * Required *
             *
             * This service exposes basic CRUD operations for the User objects.
             */
            'RcmUser\User\Service\UserDataService' =>
                'RcmUser\User\Service\Factory\UserDataService',
            /*
             * UserPropertyService
             * - Allows user properties to be set by event listeners
             * Required *
             *
             * This service allows User properties
             * to be loaded on demand using event listeners.
             * This helps reduce the size of the User object
             * as non-essential properties may be loaded when needed.
             */
            'RcmUser\User\Service\UserPropertyService' =>
                'RcmUser\User\Service\Factory\UserPropertyService',
            /*
             * UserRoleService - Core User Role data access service
             * Required *
             *
             * This service exposes basic CRUD operations for the User roles.
             */
            'RcmUser\User\Service\UserRoleService' =>
                'RcmUser\User\Service\Factory\UserRoleService',
            /*
             * UserDataMapper - Data source adapter
             * Required for:
             *  RcmUser\User\Service\UserDataService
             *
             * This is a DataMapper adapter that is used
             * to abstract the data storage method.
             * This may be configured to use a custom data mapper
             * for unique storage requirements.
             */
            'RcmUser\User\UserDataMapper' =>
                'RcmUser\User\Service\Factory\DoctrineUserDataMapper',
            /* ---------------------------- */
            /*
             * UserRolesDataMapper
             * Required for (ACL user property]:
             *  RcmUser\User\Event\UserRoleDataServiceListeners
             *
             * This is a DataMapper adapter that is used
             * to abstract the data storage method.
             * This may be configured to use a custom data mapper
             * for unique storage requirements.
             */
            'RcmUser\User\UserRolesDataMapper' =>
                'RcmUser\User\Service\Factory\DoctrineUserRoleDataMapper',
            /* - Validations - */
            /*
             * UserValidator - Validates User object data on create and update
             * Required for:
             *  RcmUser\User\Db\UserDataMapper (RcmUser\User\UserDataMapper]
             *
             * Uses the InputFilter value from the config by default.
             * This may be configured to use a custom UserValidator as required.
             */
            'RcmUser\User\Data\UserValidator' =>
                'RcmUser\User\Service\Factory\UserValidator',
            /* - Data Prep - */
            /*
             * Encryptor
             * Required for:
             *  RcmUser\User\Data\DbUserDataPreparer
             *  RcmUser\Authentication\Adapter\UserAdapter
             *
             * Used for encrypting/hashing passwords by default.
             * May not be required depending
             * on the DbUserDataPreparer and UserAdapter that is being used.
             */
            'RcmUser\User\Encryptor' => 'RcmUser\User\Service\Factory\Encryptor',
            /*
             * UserDataPreparer
             * Required for:
             *  RcmUser\User\Db\UserDataMapper (RcmUser\User\UserDataMapper]
             *
             * Used by default to prepare data for DB storage.
             * By default, encrypts passwords and creates id (UUID]
             * This may be configured to use a custom UserDataPreparer as required
             */
            'RcmUser\User\Data\UserDataPreparer' =>
                'RcmUser\User\Service\Factory\DbUserDataPreparer',
            /*
             * UserDataServiceListeners
             * Required
             *  to validate, prepare and save (CRUD] User:
             *
             * Requires: RcmUser\User\UserDataMapper
             *
             * Creates event listeners that use the UserValidator
             * to do validation checks on User create and update.
             */
            'RcmUser\User\UserDataServiceListeners' =>
                'RcmUser\User\Service\Factory\UserDataServiceListeners',
            /*
             * UserRoleDataServiceListeners
             * Required for (User Acl Property populating]:
             */
            'RcmUser\User\UserRoleDataServiceListeners' =>
                'RcmUser\User\Service\Factory\UserRoleDataServiceListeners',
            /* ************************************** */
            /* AUTH ********************************* */
            /* ************************************** */
            /*
             * UserAuthenticationService
             * Required *
             *
             * Wraps events, actions are preformed in event listeners
             * so that any auth provider may do auth logic.
             */
            'RcmUser\Authentication\Service\UserAuthenticationService' =>
                'RcmUser\Authentication\Service\Factory\UserAuthenticationService',
            /* ---------------------------- */
            /*
             * UserAdapter (requires Encryptor]
             * Required for (Auth]:
             *  RcmUser\Authentication\Service\AuthenticationService
             *
             * By default this auth Adapter uses the Encryptor
             * to validate a users credentials
             * This may be configured to use a custom auth Adapter as required
             */
            'RcmUser\Authentication\Adapter' =>
                'RcmUser\Authentication\Service\Factory\Adapter',
            /*
             * UserSession
             * Required for (Auth]:
             *  RcmUser\Authentication\Service\AuthenticationService
             *
             * By default this module uses the default session container for storage
             * This may be configured to use a custom Storage object as required
             */
            'RcmUser\Authentication\Storage' =>
                'RcmUser\Authentication\Service\Factory\Storage',
            /*
             * AuthenticationService
             * Required for:
             *  RcmUser\Authentication\EventListeners
             * 
             * By default this module uses the default Adapter and Storage
             * to do authentication
             * This may be configure to use custom AuthenticationService as required
             */
            'RcmUser\Authentication\AuthenticationService' =>
                'RcmUser\Authentication\Service\Factory\AuthenticationService',
            /*
             * EventListeners
             * Used for listening for auth related events:
             *
             * By default this module listens for the events
             * from UserAuthenticationService to do authentication
             * This may be configured to use custom event listeners
             * or disabled if not required
             */
            'RcmUser\Authentication\UserAuthenticationServiceListeners' =>
                'RcmUser\Authentication\Service\Factory\UserAuthenticationServiceListeners',
            /* ************************************** */
            /* ACL ********************************** */
            /* ************************************** */

            /*
             * AclResourceService
             * Used by:
             *  RcmUser\Acl\Provider\ResourceProvider
             *
             * Exposes this module's resource aggregation methods
             */
            'RcmUser\Acl\Service\AclResourceService' =>
                'RcmUser\Acl\Service\Factory\AclResourceService',
            /*
             * AuthorizeService (ACL]
             * Used by:
             *  RcmUserService
             *  ControllerPluginRcmUserIsAllowed
             *  ViewHelperRcmUserIsAllowed
             *
             * Exposes the ACL isAllowed method
             */
            'RcmUser\Acl\Service\AuthorizeService' =>
                'RcmUser\Acl\Service\Factory\AuthorizeService',
            /*
             * AclRoleDataMapper
             * Required
             * This data mapper adapter allows this module
             * to read roles from a data source
             * This may be configured to use a custom data mapper if required
             */
            'RcmUser\Acl\AclRoleDataMapper' =>
                'RcmUser\Acl\Service\Factory\DoctrineAclRoleDataMapper',
            /*
             * AclRuleDataMapper
             * Required for:
             * This data mapper adapter allows this module
             * to read rules from a data source
             * This may be configured to use a custom data mapper if required
             */
            'RcmUser\Acl\AclRuleDataMapper' =>
                'RcmUser\Acl\Service\Factory\DoctrineAclRuleDataMapper',
            /*
             * AclDataService
             * Required for accessing mappers
             * This is designed to expose a simple facade
             * for use in displaying and updating ACL data
             * in views
             */
            'RcmUser\Acl\AclDataService' =>
                'RcmUser\Acl\Service\Factory\AclDataService',
            /* ************************************** */
            /* CORE ********************************* */
            /* ************************************** */
            /*
             * Main service facade
             * Uses:
             *  UserDataService
             *  UserPropertyService
             *  UserAuthenticationService
             *  AuthorizeService
             */
            'RcmUser\Service\RcmUserService' =>
                'RcmUser\Service\Factory\RcmUserService',
            /**
             * Simple Access to the current user
             * Uses:
             *  UserAuthenticationService
             */
            'RcmUser\Service\CurrentUser' =>
                'RcmUser\Service\Factory\CurrentUser',
            /*
             * Provides the Access Resources for this Module to ACL
             * Required *
             */
            'RcmUser\Provider\RcmUserAclResourceProvider' =>
                'RcmUser\Service\Factory\RcmUserAclResourceProvider',
            /*
             * Event Aggregation
             * Required *
             */
            'RcmUser\Event\Listeners' => 'RcmUser\Service\Factory\EventListeners',
            /*
             * Logging
             * Required *
             */
            'RcmUser\Log\Logger' => 'RcmUser\Service\Factory\DoctrineLogger',
        ],
    ],
    /*
     * Allows doctrine to generate tables as needed
     * Only required if using doctrine entities and mappers
     * And you want doctrine utilities to work correctly
     */
    'doctrine' => [
        'driver' => [
            'RcmUser' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Acl/Entity',
                    __DIR__ . '/../src/User/Entity',
                    __DIR__ . '/../src/Log/Entity',
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'RcmUser' => 'RcmUser'
                ]
            ]
        ]
    ],
];
