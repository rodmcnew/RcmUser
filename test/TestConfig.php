<?php
return array(
    'modules' => array(
        // RcmUser dependencies
        'RcmUser',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            __DIR__ . '/../../../../config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './vendor',
            './vendor/zend',
            './vendor/reliv/',
            './vendor/phpunit/',
        ),
    ),
);