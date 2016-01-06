<?php
array(
    'root' =>
        RcmUser\Acl\Entity\RootAclResource::__set_state(
            array(
                'resourceId' => 'root',
                'providerId' => 'root',
                'parentResourceId' => null,
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'update',
                        2 => 'create',
                        3 => 'delete',
                        4 => 'execute',
                    ),
                'name' => 'Root',
                'description' => 'This is the lowest level resource. Access to this will allow access to all resources.',
            )
        ),
    'sites' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'Rcm\\Acl\\ResourceProvider',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'update',
                        2 => 'create',
                        3 => 'delete',
                        4 => 'theme',
                        5 => 'admin',
                    ),
                'name' => 'Sites',
                'description' => 'Global resource for sites',
                'resourceId' => 'sites',
            )
        ),
    'pages' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'Rcm\\Acl\\ResourceProvider',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'edit',
                        2 => 'create',
                        3 => 'delete',
                        4 => 'copy',
                        5 => 'approve',
                        6 => 'layout',
                        7 => 'revisions',
                    ),
                'name' => 'Pages',
                'description' => 'Global resource for pages',
                'resourceId' => 'pages',
            )
        ),
    'widgets' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'Rcm\\Acl\\ResourceProvider',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'update',
                    ),
                'name' => 'Widgets',
                'description' => 'Global resource for Rcm Widgets',
                'resourceId' => 'widgets',
            )
        ),
    'vista' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'Rcm\\Acl\\ResourceProvider',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'debug',
                    ),
                'name' => 'Vista',
                'description' => 'Global resource for vista',
                'resourceId' => 'vista',
            )
        ),
    'conference' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'Rcm\\Acl\\ResourceProvider',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'manage',
                    ),
                'name' => 'Conference',
                'description' => 'Resource for conference',
                'resourceId' => 'conference',
            )
        ),
    'products' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'Rcm\\Acl\\ResourceProvider',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'update',
                    ),
                'name' => 'Products',
                'description' => 'Shopping Cart Products',
                'resourceId' => 'products',
            )
        ),
    'translations' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'RcmI18nTranslations',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'update',
                        2 => 'create',
                        3 => 'delete',
                    ),
                'name' => 'Translations',
                'description' => 'Creating translations for other countries',
                'resourceId' => 'translations',
            )
        ),
    'rcmuser' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'RcmUser',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'update',
                        2 => 'create',
                        3 => 'delete',
                    ),
                'name' => 'RCM User',
                'description' => 'All RCM user access.',
                'resourceId' => 'rcmuser',
            )
        ),
    'rcmuser-user-administration' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'RcmUser',
                'parentResourceId' => 'rcmuser',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'update',
                        2 => 'create',
                        3 => 'delete',
                        4 => 'update_credentials',
                    ),
                'name' => 'User Administration',
                'description' => 'Allows the editing of user data.',
                'resourceId' => 'rcmuser-user-administration',
            )
        ),
    'rcmuser-acl-administration' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'RcmUser',
                'parentResourceId' => 'rcmuser',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'read',
                        1 => 'update',
                        2 => 'create',
                        3 => 'delete',
                    ),
                'name' => 'Role and Access Administration',
                'description' => 'Allows the editing of user access and role data.',
                'resourceId' => 'rcmuser-acl-administration',
            )
        ),
    'rcm-google-analytics' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'RcmGoogleAnalytics',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'admin',
                    ),
                'name' => 'Rcm Google Analytics',
                'description' => 'All Rcm Google Analytics access.',
                'resourceId' => 'rcm-google-analytics',
            )
        ),
    'switchuser' =>
        RcmUser\Acl\Entity\AclResource::__set_state(
            array(
                'providerId' => 'Rcm\\SwitchUser\\Acl\\ResourceProvider',
                'parentResourceId' => 'root',
                'parentResource' => null,
                'privileges' =>
                    array(
                        0 => 'execute',
                    ),
                'name' => 'RCM Switch User.',
                'description' => 'Switch user ACL resource.',
                'resourceId' => 'switchuser',
            )
        ),
);
