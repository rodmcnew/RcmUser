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

return array(

    'RcmUser' => array(
        'User\Config' => array(

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
             *  RcmUser\User\Data\UserValidator
             *
             * If validator is used, this input filter will be applied
             * to the User object on create and save.
             */
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
                        /*
                        array(
                            'name' => 'Regex',
                            'options' => array(
                                'pattern' => '^(?=.*\d)(?=.*[a-zA-Z])$'
                            ),
                        ),
                        */
                    ),
                ),
            ),
        ),

        'Auth\Config' => array(
            'ObfuscatePasswordOnAuth' => true,
        ),

        'Acl\Config' => array(

            /*
             * DefaultRoleIdentities and DefaultAuthenticatedRoleIdentities
             * Used by:
             *  RcmUser\Acl\EventListeners
             *
             * These event listeners inject the ACL roles property
             * for a user on the user data events
             * in RcmUser\User\Service\UserDataService.
             */
            'DefaultRoleIdentities' => array('guest'),
            'DefaultAuthenticatedRoleIdentities' => array('user'),

            /*
             * ResourceProviders
             * Used in:
             *  RcmUser\Acl\Service\AclResourceService
             *
             * This aggregates resources that may be injected by any module,
             * this module wraps the resources
             * in a core resource with common privileges.
             *
             * Format for each value of this array is:
             * 'MyResourceName(Will be top level of resource)' =>
             * 'MyResource/ResourceProvider(ResourceProviderInterface)',
             */
            'ResourceProviders' => array(
                /*
                 * RcmUserAccess
                 * This module inject some of this module's resources.
                 */
                'RcmUserAccess' => 'RcmUser\Provider\RcmUserAclResourceProvider',
            ),
        ),
    ),

    'service_manager' => array(
        'factories' => array(
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
             * Required for (ACL user property):
             *  RcmUser\Acl\Service\Factory\EventListeners
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
             *  RcmUser\User\Db\AbstractUserDataMapper (RcmUser\User\UserDataMapper)
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
             * UserDataPreparer (requires Encryptor)
             * Required for:
             *  RcmUser\User\Db\AbstractUserDataMapper (RcmUser\User\UserDataMapper)
             *
             * Used by default to prepare data for DB storage.
             * By default, encrypts passwords and creates id (UUID)
             * This may be configured to use a custom UserDataPreparer as required
             */
            'RcmUser\User\Data\UserDataPreparer' =>
                'RcmUser\User\Service\Factory\DbUserDataPreparer',

            /*
             * UserDataServiceListeners
             * Required
             *  to validate, prepare and save (CRUD) User:
             *
             * Requires: RcmUser\User\UserDataMapper
             *
             * Creates event listeners that use the UserValidator
             * to do validation checks on User create and update.
             */
            'RcmUser\User\UserDataServiceListeners' =>
                'RcmUser\User\Service\Factory\UserDataServiceListeners',

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
             * UserAdapter (requires Encryptor)
             * Required for (Auth):
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
             * Required for (Auth):
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
             *  RcmUser\Acl\Provider\BjyResourceProvider
             *
             * Exposes this module's resource aggregation methods
             */
            'RcmUser\Acl\Service\AclResourceService' =>
                'RcmUser\Acl\Service\Factory\AclResourceService',

            /*
             * UserAuthorizeService (ACL)
             * Used by:
             *  RcmUserService
             *  ControllerPluginRcmUserIsAllowed
             *  ViewHelperRcmUserIsAllowed
             *
             * Exposes the ACL isAllowed method
             */
            'RcmUser\Acl\Service\UserAuthorizeService' =>
                'RcmUser\Acl\Service\Factory\UserAuthorizeService',
            /*
             * AclRoleDataMapper
             * Required for:
             *  BjyRoleProvider
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
             * UserDataServiceListeners
             * Required for (User Property populating):
             */
            'RcmUser\Acl\UserDataServiceListeners' =>
                'RcmUser\Acl\Service\Factory\UserDataServiceListeners',

            /*
             * BJY-Authorize providers
             * - This module depends on bjyauthorize for ACL logic
             * Required for BjyAuthorize:
             *
             * This module builds the required providers for bjyauthorize
             */
            'RcmUser\Acl\Provider\BjyIdentityProvider' =>
                'RcmUser\Acl\Service\Factory\BjyIdentityProvider',
            'RcmUser\Acl\Provider\BjyRoleProvider' =>
                'RcmUser\Acl\Service\Factory\BjyRoleProvider',
            'RcmUser\Acl\Provider\BjyRuleProvider' =>
                'RcmUser\Acl\Service\Factory\BjyRuleProvider',
            'RcmUser\Acl\Provider\BjyResourceProvider' =>
                'RcmUser\Acl\Service\Factory\BjyResourceProvider',


            /* ************************************** */
            /* CORE ********************************* */
            /* ************************************** */
            /*
             * Main service facade
             * Uses:
             *  UserDataService
             *  UserPropertyService
             *  UserAuthenticationService
             *  UserAuthorizeService
             */
            'RcmUser\Service\RcmUserService' =>
                'RcmUser\Service\Factory\RcmUserService',

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
        ),
    ),

    /*
     * bjyauthorize configuration
     *
     * This module inject providers to bjyauthorize
     */
    'bjyauthorize' => array(
        'default_role' => 'guest',
        'authenticated_role' => 'user',
        'identity_provider' => 'RcmUser\Acl\Provider\BjyIdentityProvider',
        'role_providers' => array(
            'RcmUser\Acl\Provider\BjyRoleProvider' => array('guest'),
        ),
        'resource_providers' => array(
            'RcmUser\Acl\Provider\BjyResourceProvider' => array(),
        ),
        'rule_providers' => array(
            'RcmUser\Acl\Provider\BjyRuleProvider' => array(),
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

    'controller_plugins' => array(
        'factories' => array(
            'rcmUserIsAllowed' =>
                'RcmUser\Service\Factory\ControllerPluginRcmUserIsAllowed',
        ),
    ),

    'view_helpers' => array(
        'factories' => array(
            'rcmUserIsAllowed' =>
                'RcmUser\Service\Factory\ViewHelperRcmUserIsAllowed',
        ),
    ),


);
