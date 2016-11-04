<?php
/**
 * doctrine.php
 */
return [
    /*
     * Allows doctrine to generate tables as needed
     * Only required if using doctrine entities and mappers
     * And you want doctrine utilities to work correctly
     */
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
];
