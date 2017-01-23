<?php
/**
 * dependencies.php
 */
return [

    'factories' => [
        /*
         * Config
         */
        RcmUser\Config\Config::class => RcmUser\Config\ConfigFactory::class,
        RcmUser\User\Config::class => RcmUser\User\ConfigFactory::class,
        RcmUser\Authentication\Config::class => RcmUser\Authentication\ConfigFactory::class,
        RcmUser\Acl\Config::class => RcmUser\Acl\ConfigFactory::class,
        RcmUser\Log\Config::class => RcmUser\Log\ConfigFactory::class,
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
            RcmUser\User\Service\UserDataServiceFactory::class,
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
            RcmUser\User\Service\UserPropertyServiceFactory::class,
        /*
         * UserRoleService - Core User Role data access service
         * Required *
         *
         * This service exposes basic CRUD operations for the User roles.
         */
        RcmUser\User\Service\UserRoleService::class =>
            RcmUser\User\Service\UserRoleServiceFactory::class,
        /*
         * UserDataMapper - Data source adapter
         * Required for:
         *  RcmUser\User\Service\UserDataService
         *
         * Old Service Name: 'RcmUser\User\UserDataMapper'
         *
         * This is a DataMapper adapter that is used
         * to abstract the data storage method.
         * This may be configured to use a custom data mapper
         * for unique storage requirements.
         */
        RcmUser\User\Db\UserDataMapper::class =>
            RcmUser\User\Db\DoctrineUserDataMapperFactory::class,
        /* ---------------------------- */
        /*
         * UserRolesDataMapper
         * Required for (ACL user property]:
         *  RcmUser\User\Event\UserRoleDataServiceListeners
         *
         * Old Service Name: 'RcmUser\User\UserRolesDataMapper'
         *
         * This is a DataMapper adapter that is used
         * to abstract the data storage method.
         * This may be configured to use a custom data mapper
         * for unique storage requirements.
         */
        RcmUser\User\Db\UserRolesDataMapper::class =>
            RcmUser\User\Db\DoctrineUserRoleDataMapperFactory::class,
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
            RcmUser\User\Data\UserValidatorFactory::class,
        /* - Data Prep - */
        /*
         * Encryptor
         * Required for:
         *  RcmUser\User\Data\DbUserDataPreparer
         *  RcmUser\Authentication\Adapter\UserAdapter
         *
         * Old Service Name: 'RcmUser\User\Encryptor'
         *
         * Used for encrypting/hashing passwords by default.
         * May not be required depending
         * on the DbUserDataPreparer and UserAdapter that is being used.
         */
        RcmUser\User\Password\Password::class =>
            RcmUser\User\Password\EncryptorFactory::class,
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
            RcmUser\User\Data\DbUserDataPreparerFactory::class,
        /*
         * UserDataServiceListeners
         * Required
         *  to validate, prepare and save (CRUD] User:
         *
         * Requires: RcmUser\User\UserDataMapper
         *
         * Old Service Name: 'RcmUser\User\UserDataServiceListeners'
         *
         * Creates event listeners that use the UserValidator
         * to do validation checks on User create and update.
         */
        RcmUser\User\Event\UserDataServiceListeners::class =>
            RcmUser\User\Event\UserDataServiceListenersFactory::class,
        /*
         * UserRoleDataServiceListeners
         * Required for (User Acl Property populating]:
         * Old Service Name: 'RcmUser\User\UserRoleDataServiceListeners'
         */
        RcmUser\User\Event\UserRoleDataServiceListeners::class =>
            RcmUser\User\Event\UserRoleDataServiceListenersFactory::class,
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
            RcmUser\Authentication\Service\UserAuthenticationServiceFactory::class,
        /* ---------------------------- */
        /*
         * UserAdapter (requires Encryptor]
         * Required for (Auth]:
         *  RcmUser\Authentication\Service\AuthenticationService
         *
         * Old Service Name: 'RcmUser\Authentication\Adapter'
         *
         * By default this auth Adapter uses the Encryptor
         * to validate a users credentials
         * This may be configured to use a custom auth Adapter as required
         */
        RcmUser\Authentication\Adapter\Adapter::class =>
            RcmUser\Authentication\Adapter\UserAdapterFactory::class,
        /*
         * UserSession
         * Required for (Auth]:
         *  RcmUser\Authentication\Service\AuthenticationService
         *
         * Old Service Name: 'RcmUser\Authentication\Storage'
         *
         * By default this module uses the default session container for storage
         * This may be configured to use a custom Storage object as required
         */
        RcmUser\Authentication\Storage\Session::class =>
            RcmUser\Authentication\Storage\UserSessionFactory::class,
        /*
         * AuthenticationService
         * Required for:
         *  RcmUser\Authentication\EventListeners
         *
         * Old Service Name: 'RcmUser\Authentication\AuthenticationService'
         *
         * By default this module uses the default Adapter and Storage
         * to do authentication
         * This may be configure to use custom AuthenticationService as required
         */
        RcmUser\Authentication\Service\AuthenticationService::class =>
            RcmUser\Authentication\Service\AuthenticationServiceFactory::class,
        /*
         * EventListeners
         * Used for listening for auth related events:
         *
         * Old Service Name: 'RcmUser\Authentication\UserAuthenticationServiceListeners'
         *
         * By default this module listens for the events
         * from UserAuthenticationService to do authentication
         * This may be configured to use custom event listeners
         * or disabled if not required
         */
        RcmUser\Authentication\Event\UserAuthenticationServiceListeners::class =>
            RcmUser\Authentication\Event\UserAuthenticationServiceListenersFactory::class,

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
            RcmUser\Acl\Service\AclResourceServiceFactory::class,
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
            RcmUser\Acl\Service\AuthorizeServiceFactory::class,

        /*
         * AclResourceNsArrayService
         *
         * Exposes a data prep for creating namespaces based on resource
         */
        RcmUser\Acl\Service\AclResourceNsArrayService::class =>
            RcmUser\Acl\Service\AclResourceNsArrayServiceFactory::class,
        /*
         * RootResourceProvider
         *
         * Old Service Name: 'RcmUser\Acl\RootResourceProvider'
         *
         * Provides the root resource
         */
        RcmUser\Acl\Provider\RootResourceProvider::class =>
            RcmUser\Acl\Provider\RootResourceProviderFactory::class,
        /*
         * RcmUser\Acl\ResourceProvider
         *
         * Old Service Name: 'RcmUser\Acl\ResourceProvider'
         *
         * Main Resource provider
         * By default it wraps all other resource providers
         * NOTE: Over-riding this is touchy
         *       as it handles the resource normalization and other details
         */
        RcmUser\Acl\Provider\ResourceProvider::class =>
            RcmUser\Acl\Provider\CompositeResourceProviderFactory::class,
        /*
         * RcmUser\Acl\ResourceCache
         *
         * Old Service Name: 'RcmUser\Acl\ResourceCache'
         *
         * Resource Caching
         * By default caches to an array
         */
        RcmUser\Acl\Cache\ResourceCache::class =>
            RcmUser\Acl\Cache\ResourceCacheArrayFactory::class,
        /*
         * RcmUser\Acl\RootAclResource
         *
         * Old Service Name: 'RcmUser\Acl\RootAclResource'
         *
         * Root resource used for wrapping all other resources
         */
        RcmUser\Acl\Entity\RootAclResource::class =>
            RcmUser\Acl\Entity\RootAclResourceFactory::class,
        /*
         * AclResourceBuilder
         */
        RcmUser\Acl\Builder\AclResourceBuilder::class =>
            RcmUser\Acl\Builder\AclResourceBuilderFactory::class,
        /*
         * AclResourceStackBuilder
         */
        RcmUser\Acl\Builder\AclResourceStackBuilder::class =>
            RcmUser\Acl\Builder\AclResourceStackBuilderFactory::class,
        /*
         * ResourceProviderBuilder
         */
        RcmUser\Acl\Builder\ResourceProviderBuilder::class =>
            RcmUser\Acl\Builder\ResourceProviderBuilderFactory::class,
        /*
         * AclRoleDataMapper
         *
         * Old Service Name: 'RcmUser\Acl\AclRoleDataMapper'
         *
         * Required
         * This data mapper adapter allows this module
         * to read roles from a data source
         * This may be configured to use a custom data mapper if required
         */
        RcmUser\Acl\Db\AclRoleDataMapper::class =>
            RcmUser\Acl\Db\DoctrineAclRoleDataMapperFactory::class,
        /*
         * AclRuleDataMapper
         *
         * Old Service Name: 'RcmUser\Acl\AclRuleDataMapper'
         *
         * Required for:
         * This data mapper adapter allows this module
         * to read rules from a data source
         * This may be configured to use a custom data mapper if required
         */
        RcmUser\Acl\Db\AclRuleDataMapper::class =>
            RcmUser\Acl\Db\DoctrineAclRuleDataMapperFactory::class,
        /*
         * AclDataService
         *
         * Old Service Name: 'RcmUser\Acl\AclDataService'
         *
         * Required for accessing mappers
         * This is designed to expose a simple facade
         * for use in displaying and updating ACL data
         * in views
         */
        RcmUser\Acl\Service\AclDataService::class =>
            RcmUser\Acl\Service\AclDataServiceFactory::class,

        /**
         * AclListeners
         */
        RcmUser\Acl\Event\AclListeners::class =>
            RcmUser\Acl\Event\AclListenersFactory::class,

        /**
         * IsAllowedErrorExceptionListener
         */
        RcmUser\Acl\Event\IsAllowedErrorExceptionListener::class =>
            RcmUser\Acl\Event\IsAllowedErrorExceptionListenerFactory::class,
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
            RcmUser\Service\RcmUserServiceFactory::class,
        /**
         * Simple Access to the current user
         * Uses:
         *  UserAuthenticationService
         */
        RcmUser\Service\CurrentUser::class =>
            RcmUser\Service\CurrentUserFactory::class,
        /*
         * Provides the Access Resources for this Module to ACL
         * Required *
         */
        RcmUser\Provider\RcmUserAclResourceProvider::class =>
            RcmUser\Provider\RcmUserAclResourceProviderFactory::class,
        /*
         * Event Aggregation
         *
         * Old Service Name: 'RcmUser\Event\Listeners'
         *
         * Required *
         */
        RcmUser\Event\ListenerCollection::class =>
            RcmUser\Event\ListenerCollectionFactory::class,

        /**
         * UserEventManager
         */
        RcmUser\Event\UserEventManager::class =>
            RcmUser\Event\UserEventManagerFactory::class,
        /*
         * Logging
         * Required *
         */
        RcmUser\Log\Logger::class =>
            RcmUser\Log\DoctrineLoggerFactory::class,

        /*
         * LoggerListeners
         */
        RcmUser\Log\Event\LoggerListeners::class =>
            RcmUser\Log\Event\LoggerListenersFactory::class,

        /*
         * AclDataService Log Listeners
         */
        RcmUser\Log\Event\AclDataService\CreateAclRoleFailListener::class =>
            RcmUser\Log\Event\AclDataService\CreateAclRoleFailListenerFactory::class,
        RcmUser\Log\Event\AclDataService\CreateAclRoleListener::class =>
            RcmUser\Log\Event\AclDataService\CreateAclRoleListenerFactory::class,
        RcmUser\Log\Event\AclDataService\CreateAclRoleSuccessListener::class =>
            RcmUser\Log\Event\AclDataService\CreateAclRoleSuccessListenerFactory::class,

        RcmUser\Log\Event\AclDataService\CreateAclRuleFailListener::class =>
            RcmUser\Log\Event\AclDataService\CreateAclRuleFailListenerFactory::class,
        RcmUser\Log\Event\AclDataService\CreateAclRuleListener::class =>
            RcmUser\Log\Event\AclDataService\CreateAclRuleListenerFactory::class,
        RcmUser\Log\Event\AclDataService\CreateAclRuleSuccessListener::class =>
            RcmUser\Log\Event\AclDataService\CreateAclRuleSuccessListenerFactory::class,

        RcmUser\Log\Event\AclDataService\DeleteAclRoleFailListener::class =>
            RcmUser\Log\Event\AclDataService\DeleteAclRoleFailListenerFactory::class,
        RcmUser\Log\Event\AclDataService\DeleteAclRoleListener::class =>
            RcmUser\Log\Event\AclDataService\DeleteAclRoleListenerFactory::class,
        RcmUser\Log\Event\AclDataService\DeleteAclRoleSuccessListener::class =>
            RcmUser\Log\Event\AclDataService\DeleteAclRoleSuccessListenerFactory::class,

        RcmUser\Log\Event\AclDataService\DeleteAclRuleFailListener::class =>
            RcmUser\Log\Event\AclDataService\DeleteAclRuleFailListenerFactory::class,
        RcmUser\Log\Event\AclDataService\DeleteAclRuleListener::class =>
            RcmUser\Log\Event\AclDataService\DeleteAclRuleListenerFactory::class,
        RcmUser\Log\Event\AclDataService\DeleteAclRuleSuccessListener::class =>
            RcmUser\Log\Event\AclDataService\DeleteAclRuleSuccessListenerFactory::class,

        /**
         * AuthorizeService Log Listeners
         */
        RcmUser\Log\Event\AuthorizeService\IsAllowedErrorListener::class =>
            RcmUser\Log\Event\AuthorizeService\IsAllowedErrorListenerFactory::class,
        RcmUser\Log\Event\AuthorizeService\IsAllowedFalseListener::class =>
            RcmUser\Log\Event\AuthorizeService\IsAllowedFalseListenerFactory::class,
        RcmUser\Log\Event\AuthorizeService\IsAllowedSuperAdminListener::class =>
            RcmUser\Log\Event\AuthorizeService\IsAllowedSuperAdminListenerFactory::class,
        RcmUser\Log\Event\AuthorizeService\IsAllowedTrueListener::class =>
            RcmUser\Log\Event\AuthorizeService\IsAllowedTrueListenerFactory::class,

        /*
         * UserAuthenticationService Log Listeners
         */
        RcmUser\Log\Event\UserAuthenticationService\AuthenticateFailListener::class =>
            RcmUser\Log\Event\UserAuthenticationService\AuthenticateFailListenerFactory::class,
        RcmUser\Log\Event\UserAuthenticationService\ValidateCredentialsFailListener::class =>
            RcmUser\Log\Event\UserAuthenticationService\ValidateCredentialsFailListenerFactory::class,

        /**
         * UserDataService Log Listeners
         */
        RcmUser\Log\Event\UserDataService\CreateUserFailListener::class =>
            RcmUser\Log\Event\UserDataService\CreateUserFailListenerFactory::class,
        RcmUser\Log\Event\UserDataService\CreateUserListener::class =>
            RcmUser\Log\Event\UserDataService\CreateUserListenerFactory::class,
        RcmUser\Log\Event\UserDataService\CreateUserSuccessListener::class =>
            RcmUser\Log\Event\UserDataService\CreateUserSuccessListenerFactory::class,

        RcmUser\Log\Event\UserDataService\DeleteUserFailListener::class =>
            RcmUser\Log\Event\UserDataService\DeleteUserFailListenerFactory::class,
        RcmUser\Log\Event\UserDataService\DeleteUserListener::class =>
            RcmUser\Log\Event\UserDataService\DeleteUserListenerFactory::class,
        RcmUser\Log\Event\UserDataService\DeleteUserSuccessListener::class =>
            RcmUser\Log\Event\UserDataService\DeleteUserSuccessListenerFactory::class,

        RcmUser\Log\Event\UserDataService\UpdateUserFailListener::class =>
            RcmUser\Log\Event\UserDataService\UpdateUserFailListenerFactory::class,
        RcmUser\Log\Event\UserDataService\UpdateUserListener::class =>
            RcmUser\Log\Event\UserDataService\UpdateUserListenerFactory::class,
        RcmUser\Log\Event\UserDataService\UpdateUserSuccessListener::class =>
            RcmUser\Log\Event\UserDataService\UpdateUserSuccessListenerFactory::class,

        /**
         * UserRoleService Log Listeners
         */
        RcmUser\Log\Event\UserRoleService\AddUserRoleFailListener::class =>
            RcmUser\Log\Event\UserRoleService\AddUserRoleFailListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\AddUserRoleListener::class =>
            RcmUser\Log\Event\UserRoleService\AddUserRoleListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\AddUserRoleSuccessListener::class =>
            RcmUser\Log\Event\UserRoleService\AddUserRoleSuccessListenerFactory::class,

        RcmUser\Log\Event\UserRoleService\CreateUserRolesFailListener::class =>
            RcmUser\Log\Event\UserRoleService\CreateUserRolesFailListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\CreateUserRolesListener::class =>
            RcmUser\Log\Event\UserRoleService\CreateUserRolesListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\CreateUserRolesSuccessListener::class =>
            RcmUser\Log\Event\UserRoleService\CreateUserRolesSuccessListenerFactory::class,

        RcmUser\Log\Event\UserRoleService\DeleteUserRolesFailListener::class =>
            RcmUser\Log\Event\UserRoleService\DeleteUserRolesFailListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\DeleteUserRolesListener::class =>
            RcmUser\Log\Event\UserRoleService\DeleteUserRolesListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\DeleteUserRolesSuccessListener::class =>
            RcmUser\Log\Event\UserRoleService\DeleteUserRolesSuccessListenerFactory::class,

        RcmUser\Log\Event\UserRoleService\RemoveUserRoleFailListener::class =>
            RcmUser\Log\Event\UserRoleService\RemoveUserRoleFailListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\RemoveUserRoleListener::class =>
            RcmUser\Log\Event\UserRoleService\RemoveUserRoleListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\RemoveUserRoleSuccessListener::class =>
            RcmUser\Log\Event\UserRoleService\RemoveUserRoleSuccessListenerFactory::class,

        RcmUser\Log\Event\UserRoleService\UpdateUserRolesFailListener::class =>
            RcmUser\Log\Event\UserRoleService\UpdateUserRolesFailListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\UpdateUserRolesListener::class =>
            RcmUser\Log\Event\UserRoleService\UpdateUserRolesListenerFactory::class,
        RcmUser\Log\Event\UserRoleService\UpdateUserRolesSuccessListener::class =>
            RcmUser\Log\Event\UserRoleService\UpdateUserRolesSuccessListenerFactory::class,
    ],
];
