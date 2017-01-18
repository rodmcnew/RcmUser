<?php
/**
 * dependencies.php
 */
return [

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
        RcmUser\User\Service\UserDataService::class =>
            RcmUser\User\Service\Factory\UserDataService::class,
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
        RcmUser\User\Service\UserPropertyService::class =>
            RcmUser\User\Service\Factory\UserPropertyService::class,
        /*
         * UserRoleService - Core User Role data access service
         * Required *
         *
         * This service exposes basic CRUD operations for the User roles.
         */
        RcmUser\User\Service\UserRoleService::class =>
            RcmUser\User\Service\Factory\UserRoleService::class,
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
        RcmUser\User\Db\UserDataMapper::class =>
            RcmUser\User\Service\Factory\DoctrineUserDataMapper::class,
        /**
         * @deprecated USE: RcmUser\User\Db\UserDataMapper::class
         */
        'RcmUser\User\UserDataMapper' =>
            RcmUser\User\Service\Factory\DoctrineUserDataMapper::class,
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
        RcmUser\User\Db\UserRolesDataMapper::class =>
            RcmUser\User\Service\Factory\DoctrineUserRoleDataMapper::class,
        /**
         * @deprecated USE: RcmUser\User\Db\UserRolesDataMapper::class
         */
        'RcmUser\User\UserRolesDataMapper' =>
            RcmUser\User\Service\Factory\DoctrineUserRoleDataMapper::class,
        /* - Validations - */
        /*
         * UserValidator - Validates User object data on create and update
         * Required for:
         *  RcmUser\User\Db\UserDataMapper (RcmUser\User\UserDataMapper]
         *
         * Uses the InputFilter value from the config by default.
         * This may be configured to use a custom UserValidator as required.
         */
        RcmUser\User\Data\UserValidator::class =>
            RcmUser\User\Service\Factory\UserValidator::class,
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
        RcmUser\User\Password\Password::class =>
            RcmUser\User\Service\Factory\Encryptor::class,
        /**
         * @deprecated USE: RcmUser\User\Password\Password::class
         */
        'RcmUser\User\Encryptor' =>
            RcmUser\User\Service\Factory\Encryptor::class,
        /*
         * UserDataPreparer
         * Required for:
         *  RcmUser\User\Db\UserDataMapper (RcmUser\User\UserDataMapper]
         *
         * Used by default to prepare data for DB storage.
         * By default, encrypts passwords and creates id (UUID]
         * This may be configured to use a custom UserDataPreparer as required
         */
        RcmUser\User\Data\UserDataPreparer::class =>
            RcmUser\User\Service\Factory\DbUserDataPreparer::class,
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
        RcmUser\User\Event\UserDataServiceListeners::class =>
            RcmUser\User\Service\Factory\UserDataServiceListeners::class,
        /**
         * @deprecated USE: RcmUser\User\Event\UserDataServiceListeners::class
         */
        'RcmUser\User\UserDataServiceListeners' =>
            RcmUser\User\Service\Factory\UserDataServiceListeners::class,
        /*
         * UserRoleDataServiceListeners
         * Required for (User Acl Property populating]:
         */
        RcmUser\User\Event\UserRoleDataServiceListeners::class =>
            RcmUser\User\Service\Factory\UserRoleDataServiceListeners::class,
        /**
         * @deprecated USE: RcmUser\User\Event\UserRoleDataServiceListeners::class
         */
        'RcmUser\User\UserRoleDataServiceListeners' =>
            RcmUser\User\Service\Factory\UserRoleDataServiceListeners::class,
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
        RcmUser\Authentication\Service\UserAuthenticationService::class =>
            RcmUser\Authentication\Service\Factory\UserAuthenticationService::class,
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
        RcmUser\Authentication\Adapter\Adapter::class =>
            RcmUser\Authentication\Service\Factory\Adapter::class,
        /**
         * @deprecated USE: RcmUser\Authentication\Adapter\Adapter::class
         */
        'RcmUser\Authentication\Adapter' =>
            RcmUser\Authentication\Service\Factory\Adapter::class,
        /*
         * UserSession
         * Required for (Auth]:
         *  RcmUser\Authentication\Service\AuthenticationService
         *
         * By default this module uses the default session container for storage
         * This may be configured to use a custom Storage object as required
         */
        RcmUser\Authentication\Storage\Session::class =>
            RcmUser\Authentication\Service\Factory\Storage::class,
        /**
         * @deprecated USE: RcmUser\Authentication\Storage\Session::class
         */
        'RcmUser\Authentication\Storage' =>
            RcmUser\Authentication\Service\Factory\Storage::class,
        /*
         * AuthenticationService
         * Required for:
         *  RcmUser\Authentication\EventListeners
         *
         * By default this module uses the default Adapter and Storage
         * to do authentication
         * This may be configure to use custom AuthenticationService as required
         */
        RcmUser\Authentication\Service\AuthenticationService::class =>
            RcmUser\Authentication\Service\Factory\AuthenticationService::class,
        /**
         * @deprecated USE: RcmUser\Authentication\Service\AuthenticationService::class
         */
        'RcmUser\Authentication\AuthenticationService' =>
            RcmUser\Authentication\Service\Factory\AuthenticationService::class,
        /*
         * EventListeners
         * Used for listening for auth related events:
         *
         * By default this module listens for the events
         * from UserAuthenticationService to do authentication
         * This may be configured to use custom event listeners
         * or disabled if not required
         */
        RcmUser\Authentication\Event\UserAuthenticationServiceListeners::class =>
            RcmUser\Authentication\Service\Factory\UserAuthenticationServiceListeners::class,
        /**
         * @deprecated USE: RcmUser\Authentication\Event\UserAuthenticationServiceListeners::class
         */
        'RcmUser\Authentication\UserAuthenticationServiceListeners' =>
            RcmUser\Authentication\Service\Factory\UserAuthenticationServiceListeners::class,
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
        RcmUser\Acl\Service\AclResourceService::class =>
            RcmUser\Acl\Service\Factory\AclResourceService::class,
        /*
         * AuthorizeService (ACL)
         * Used by:
         *  RcmUserService
         *  ControllerPluginRcmUserIsAllowed
         *  ViewHelperRcmUserIsAllowed
         *
         * Exposes the ACL isAllowed method
         */
        RcmUser\Acl\Service\AuthorizeService::class =>
            RcmUser\Acl\Service\Factory\AuthorizeService::class,

        /*
         * AclResourceNsArrayService
         *
         * Exposes a data prep for creating namespaces based on resource
         */
        RcmUser\Acl\Service\AclResourceNsArrayService::class =>
            RcmUser\Acl\Service\Factory\AclResourceNsArrayService::class,
        /*
         * RootResourceProvider
         *
         * Provides the root resource
         */
        RcmUser\Acl\Provider\RootResourceProvider::class =>
            RcmUser\Acl\Service\Factory\RootResourceProvider::class,
        /**
         * @deprecated USE: RcmUser\Acl\Provider\RootResourceProvider::class
         */
        'RcmUser\Acl\RootResourceProvider' =>
            RcmUser\Acl\Service\Factory\RootResourceProvider::class,
        /*
         * RcmUser\Acl\ResourceProvider
         *
         * Main Resource provider
         * By default it wraps all other resource providers
         * NOTE: Over-riding this is touchy
         *       as it handles the resource normalization and other details
         */
        RcmUser\Acl\Provider\ResourceProvider::class =>
            RcmUser\Acl\Service\Factory\CompositeResourceProvider::class,
        /**
         * @deprecated USE: RcmUser\Acl\Provider\ResourceProvider::class
         */
        'RcmUser\Acl\ResourceProvider' =>
            RcmUser\Acl\Service\Factory\CompositeResourceProvider::class,
        /*
         * RcmUser\Acl\ResourceCache
         *
         * Resource Caching
         * By default caches to an array
         */
        RcmUser\Acl\Cache\ResourceCache::class =>
            RcmUser\Acl\Service\Factory\ResourceCacheArray::class,
        /**
         * @deprecated USE: RcmUser\Acl\Cache\ResourceCache::class
         */
        'RcmUser\Acl\ResourceCache' =>
            RcmUser\Acl\Service\Factory\ResourceCacheArray::class,
        /*
         * RcmUser\Acl\RootAclResource
         *
         * Root resource used for wrapping all other resources
         */
        RcmUser\Acl\Entity\RootAclResource::class =>
            RcmUser\Acl\Service\Factory\RootAclResource::class,
        /**
         * @deprecated USE: RcmUser\Acl\Entity\RootAclResource::class
         */
        'RcmUser\Acl\RootAclResource' =>
            RcmUser\Acl\Service\Factory\RootAclResource::class,
        /*
         * AclResourceBuilder
         */
        RcmUser\Acl\Builder\AclResourceBuilder::class =>
            RcmUser\Acl\Service\Factory\AclResourceBuilder::class,
        /*
         * AclResourceStackBuilder
         */
        RcmUser\Acl\Builder\AclResourceStackBuilder::class =>
            RcmUser\Acl\Service\Factory\AclResourceStackBuilder::class,
        /*
         * ResourceProviderBuilder
         */
        RcmUser\Acl\Builder\ResourceProviderBuilder::class =>
            RcmUser\Acl\Service\Factory\ResourceProviderBuilder::class,
        /*
         * AclRoleDataMapper
         * Required
         * This data mapper adapter allows this module
         * to read roles from a data source
         * This may be configured to use a custom data mapper if required
         */
        RcmUser\Acl\Db\AclRoleDataMapper::class =>
            RcmUser\Acl\Service\Factory\DoctrineAclRoleDataMapper::class,
        /**
         * @deprecated USE: RcmUser\Acl\Db\AclRoleDataMapper::class
         */
        'RcmUser\Acl\AclRoleDataMapper' =>
            RcmUser\Acl\Service\Factory\DoctrineAclRoleDataMapper::class,
        /*
         * AclRuleDataMapper
         * Required for:
         * This data mapper adapter allows this module
         * to read rules from a data source
         * This may be configured to use a custom data mapper if required
         */
        RcmUser\Acl\Db\AclRuleDataMapper::class =>
            RcmUser\Acl\Service\Factory\DoctrineAclRuleDataMapper::class,
        /**
         * @deprecated USE: RcmUser\Acl\Db\AclRuleDataMapper::class
         */
        'RcmUser\Acl\AclRuleDataMapper' =>
            RcmUser\Acl\Service\Factory\DoctrineAclRuleDataMapper::class,
        /*
         * AclDataService
         * Required for accessing mappers
         * This is designed to expose a simple facade
         * for use in displaying and updating ACL data
         * in views
         */
        RcmUser\Acl\Service\AclDataService::class =>
            RcmUser\Acl\Service\Factory\AclDataService::class,
        /**
         * @deprecated USE: RcmUser\Acl\Service\AclDataService::class
         */
        'RcmUser\Acl\AclDataService' =>
            RcmUser\Acl\Service\Factory\AclDataService::class,
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
        RcmUser\Service\RcmUserService::class =>
            RcmUser\Service\Factory\RcmUserService::class,
        /**
         * Simple Access to the current user
         * Uses:
         *  UserAuthenticationService
         */
        RcmUser\Service\CurrentUser::class =>
            RcmUser\Service\Factory\CurrentUser::class,
        /*
         * Provides the Access Resources for this Module to ACL
         * Required *
         */
        RcmUser\Provider\RcmUserAclResourceProvider::class =>
            RcmUser\Service\Factory\RcmUserAclResourceProvider::class,
        /*
         * Event Aggregation
         * Required *
         */
        RcmUser\Event\ListenerCollection::class =>
            RcmUser\Service\Factory\EventListeners::class,
        /**
         * @deprecated USE: RcmUser\Event\ListenerCollection::class
         */
        'RcmUser\Event\Listeners' =>
            RcmUser\Service\Factory\EventListeners::class,

        RcmUser\Event\UserEventManager::class =>
            RcmUser\Event\UserEventManagerFactory::class,
        /*
         * Logging
         * Required *
         */
        RcmUser\Log\Logger::class => RcmUser\Service\Factory\DoctrineLogger::class,
    ],
];
