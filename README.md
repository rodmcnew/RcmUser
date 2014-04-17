RcmUser
=======

Introduction
------------

The main goal of this module is to expose a simple and configurable user object as well as the services related to user storage, access control and authentication.

Features
--------

### RcmUserService ###

The RcmUserService facade exposes all of the useful methods for manipulating a User object.

- Methods for basic create, read, update, delete
- Methods for accessing User->properties on demand (properties that are only populated as needed)
- Methods for doing authentication of user (log in, log out, credential checks)
- Methods for checking user access (ACL)

### User ###

#### User class ####

The User class is the module's main user entity.

- id
 - A unique identifier, by default this is generated on create by the DbUserDataPreparer
- username
 - A unique username
- password
 - A password, by default this is hashed by the Encryptor on create/update by the DbUserDataPreparer
 - The Auth UserAdapter also uses the same Encryptor to authenticate password
- state
 - State is used to provide a tag for the users state.
 - There is only one state provided ('disabled'), any other state my be created and utilized as needed.
- properties
 - An aggregation of arbitrary properties
 - These can be injected into the User objectic by using event listeners for the User data events or the property events.
 - These can also be injected directly in the data mappers if you provide you own.

#### User DataMapper ####

The UserDataMapper is an adapter used to populate the User object and store the user data.
By default this module uses the DoctrineUserDataMapper.
Any data mapper can be written and configured so that the user may be stored based on your requirements.

### Authentication ###



### ACL ###

Requirements
------------

- php 5.5.* (not tested on lesser versions)
- zendframework 2.2.x
- bjyoungblood/bjy-authorize 1.4.*

Optional based on configuration

- doctrine 2.x
- mysql 5.6.x (not tested on lesser versions)

Installation
------------

### Manual Install ###

- Download from GitHub
- Configure module
- Run install.sql (as needed)

Configuration
-------------

### Module Config Tree ###

```php
<?php
return array(

    'RcmUser' => array(
        'User\Config' => array(

            /*
             * DefaultUserState
             * Used in:
             *  RcmUser\User\Service\UserDataService
             *
             * This is the default user state that will be set on create/update if none is set.
             */
            'DefaultUserState' => 'disabled',

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
             * If validator is used, this input filter will be applied to the User object on create and save.
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

        'Auth\Config' => array(),

        'Acl\Config' => array(

            /*
             * DefaultRoleIdentities and DefaultAuthenticatedRoleIdentities
             * Used by:
             *  RcmUser\Acl\EventListeners
             *
             * These event listeners inject the ACL roles property for a user on the user data events in RcmUser\User\Service\UserDataService.
             */
            'DefaultRoleIdentities' => array('guest'),
            'DefaultAuthenticatedRoleIdentities' => array('user'),

            /*
             * ResourceProviders
             * Used in:
             *  RcmUser\Acl\Service\AclResourceService
             *
             * This aggregates resources that may be injected by any module, this module wraps the resources in a core resource with common privileges.
             *
             * Format for each value of this array is:
             * 'MyResourceName(Will be top level of resource)' => 'MyResource/ResourceProvider(ResourceProviderInterface)',
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

            /**
             * UserDataService - Core User data access service
             * Required *
             *
             * This service exposes basic CRUD operations for the User objects.
             */
            'RcmUser\User\Service\UserDataService' => 'RcmUser\User\Service\Factory\UserDataService',
            /**
             * UserPropertyService - Allows user properties to be set by event listeners
             * Required *
             *
             * This service allows User properties to be loaded on demand using event listeners.
             * This helps reduce the size of the User object as non-essential properties may be loaded when needed.
             */
            'RcmUser\User\Service\UserPropertyService' => 'RcmUser\User\Service\Factory\UserPropertyService',
            /**
             * UserDataMapper - Data source adapter
             * Required for:
             *  RcmUser\User\Service\UserDataService
             *
             * This is a DataMapper adapter that is used to abstract the data storage method.
             * This may be configured to use a custom data mapper for unique storage requirements.
             */
            'RcmUser\User\UserDataMapper' => 'RcmUser\User\Service\Factory\DoctrineUserDataMapper',

            /* ---------------------------- */
            /**
             * UserRolesDataMapper
             * Required for (ACL user property):
             *  RcmUser\Acl\Service\Factory\EventListeners
             *
             * This is a DataMapper adapter that is used to abstract the data storage method.
             * This may be configured to use a custom data mapper for unique storage requirements.
             */
            'RcmUser\User\UserRolesDataMapper' => 'RcmUser\User\Service\Factory\DoctrineUserRoleDataMapper',

            /* - Validations - */
            /**
             * UserValidator - Validates User object data on create and update
             * Required for:
             *  RcmUser\User\EventListeners
             *
             * Uses the InputFilter value from the config by default.
             * This may be configured to use a custom UserValidator as required.
             */
            'RcmUser\User\Data\UserValidator' => 'RcmUser\User\Service\Factory\UserValidator',
            /**
             * ValidatorEventListeners
             * Required for (User validation and input filtering):
             *  RcmUser\User\Data\UserValidator
             *
             * Creates event listeners that use the UserValidator to do validation checks on User create and update.
             */
            'RcmUser\User\ValidatorEventListeners' => 'RcmUser\User\Service\Factory\ValidatorEventListeners',

            /* - Data Prep - */
            /**
             * Encryptor
             * Required for:
             *  RcmUser\User\Data\DbUserDataPreparer
             *  RcmUser\Authentication\Adapter\UserAdapter
             *
             * Used for encrypting passwords by default.
             * May not be required depending on the DbUserDataPreparer and UserAdapter that is being used.
             */
            'RcmUser\User\Encryptor' => 'RcmUser\User\Service\Factory\Encryptor',
            /**
             * UserDataPreparer (requires Encryptor)
             * Required for:
             *  RcmUser\User\EventListeners
             *
             * Used by default to prepare data for DB storage.
             * By default, encrypts passwords and creates id (UUID)
             * This may be configured to use a custom UserDataPreparer as required
             */
            'RcmUser\User\Data\UserDataPreparer' => 'RcmUser\User\Service\Factory\DbUserDataPreparer',
            /**
             * DataPrepEventListeners
             * Required for (User preparing data for save):
             *
             * Creates event listeners that use the UserDataPreparer to prepare data on User create and update.
             */
            'RcmUser\User\DataPrepEventListeners' => 'RcmUser\User\Service\Factory\DataPrepEventListeners',

            /* ************************************** */
            /* AUTH ********************************* */
            /* ************************************** */
            /*
             * UserAuthenticationService
             * Required *
             *
             * Wraps events, actions are preformed in event listeners so that any auth provider may do auth logic.
             */
            'RcmUser\Authentication\Service\UserAuthenticationService' => 'RcmUser\Authentication\Service\Factory\UserAuthenticationService',

            /* ---------------------------- */
            /**
             * UserAdapter
             * Required for (Auth):
             *  RcmUser\Authentication\Service\AuthenticationService
             *
             * By default this auth Adapter uses the Encryptor to validate a users credentials
             * This may be configured to use a custom auth Adapter as required
             */
            'RcmUser\Authentication\Adapter' => 'RcmUser\Authentication\Service\Factory\Adapter',
            /**
             * UserSession
             * Required for (Auth):
             *  RcmUser\Authentication\Service\AuthenticationService
             *
             * By default this module uses the default session container for storage
             * This may be configured to use a custom Storage object as required
             */
            'RcmUser\Authentication\Storage' => 'RcmUser\Authentication\Service\Factory\Storage',
            /**
             * AuthenticationService
             * Required for:
             *  RcmUser\Authentication\EventListeners
             *
             * By default this module uses the default Adapter and Storage to do authentication
             * This may be configure to use custom AuthenticationService as required
             * This may be configure to use custom AuthenticationService as required
             */
            'RcmUser\Authentication\AuthenticationService' => 'RcmUser\Authentication\Service\Factory\AuthenticationService',
            /**
             * EventListeners
             * Used for listening for auth related events:
             *
             * By default this module listens for the events from UserAuthenticationService to do authentication
             * This may be configured to use custom event listeners or disabled if not required
             */
            'RcmUser\Authentication\EventListeners' => 'RcmUser\Authentication\Service\Factory\EventListeners',

            /* ************************************** */
            /* ACL ********************************** */
            /* ************************************** */

            /**
             * AclResourceService
             * Used by:
             *  RcmUser\Acl\Provider\BjyResourceProvider
             *
             * Exposes this module's resource aggregation methods
             */
            'RcmUser\Acl\Service\AclResourceService' => 'RcmUser\Acl\Service\Factory\AclResourceService',

            /**
             * UserAuthorizeService (ACL)
             * Used by RcmUserService, ControllerPluginRcmUserIsAllowed, ViewHelperRcmUserIsAllowed
             *
             * Exposes the ACL isAllowed method
             */
            'RcmUser\Acl\Service\UserAuthorizeService' => 'RcmUser\Acl\Service\Factory\UserAuthorizeService',
            /**
             * AclRoleDataMapper
             * Required for:
             *  BjyRoleProvider
             * This data mapper adapter allows this module to read roles from a data source
             * This may be configured to use a custom data mapper if required
             */
            'RcmUser\Acl\AclRoleDataMapper' => 'RcmUser\Acl\Service\Factory\DoctrineAclRoleDataMapper',
            /**
             * AclRuleDataMapper
             * Required for:
             * This data mapper adapter allows this module to read rules from a data source
             * This may be configured to use a custom data mapper if required
             */
            'RcmUser\Acl\AclRuleDataMapper' => 'RcmUser\Acl\Service\Factory\DoctrineAclRuleDataMapper',

            /**
             * EventListeners
             * Required for (User Property populating):
             */
            'RcmUser\Acl\EventListeners' => 'RcmUser\Acl\Service\Factory\EventListeners',

            /**
             * BJY-Authorize providers - This module depends on bjyauthorize for ACL logic
             * Required for BjyAuthorize:
             *
             * This module builds the required providers for bjyauthorize
             */
            'RcmUser\Acl\Provider\BjyIdentityProvider' => 'RcmUser\Acl\Service\Factory\BjyIdentityProvider',
            'RcmUser\Acl\Provider\BjyRoleProvider' => 'RcmUser\Acl\Service\Factory\BjyRoleProvider',
            'RcmUser\Acl\Provider\BjyRuleProvider' => 'RcmUser\Acl\Service\Factory\BjyRuleProvider',
            'RcmUser\Acl\Provider\BjyResourceProvider' => 'RcmUser\Acl\Service\Factory\BjyResourceProvider',

            /*
             * @override - This module requires specific functionality for isAllowed
             *
             * The UserAuthorizeService extends BjyAuthorize\Service\Authorize and overrides the isAllowed method
             * This allows use to parse our dot notation for nested resources which is used when a missing resource can inherit.
             *
             * To do this we need to provide the resource and its parent.
             * We accomplish this by passing 'PAGES.PAGE_X'.
             * Our isAllowed override allows the checking of 'PAGE_X' first and if it is not found, we check 'PAGES'.
             *
             * Example:
             *  If a resource called 'PAGES'
             *  And we want to check if the user has access to a child of 'PAGES' named 'PAGE_X'.
             *  And we know at the time of the ACL check that 'PAGE_X' might not be defined.
             *  If 'PAGE_X' is not defined, then we inherit from from 'PAGES'
             *
             */
            'BjyAuthorize\Service\Authorize' => 'RcmUser\Acl\Service\Factory\UserAuthorizeService',

            /* ************************************** */
            /* CORE ********************************* */
            /* ************************************** */
            /**
             * Main service facade
             * Uses:
             *  UserDataService
             *  UserPropertyService
             *  UserAuthenticationService
             *  UserAuthorizeService
             */
            'RcmUser\Service\RcmUserService' => 'RcmUser\Service\Factory\RcmUserService',

            /**
             * Provides the Access Resources for this Module to ACL
             * Require *
             */
            'RcmUser\Provider\RcmUserAclResourceProvider' => 'RcmUser\Service\Factory\RcmUserAclResourceProvider',

            /**
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

```