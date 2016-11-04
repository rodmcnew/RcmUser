<?php
/**
 * module.config.php
 *
 * Module configuration
 */
return [
    'RcmUser' => require(__DIR__ . '/rcm-user.php'),
    'service_manager' => require(__DIR__ . '/dependencies.php'),
    'doctrine' => require(__DIR__ . '/doctrine.php'),
];
