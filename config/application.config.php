<?php

return array(
    'modules' => array(
        'Application',
        'ZendDeveloperTools',
        'DoctrineModule',
        'DoctrineORMModule',
        'SCToolbox',
        'Cloud',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
    'SCToolbox' => array(
        'path' => realpath(__DIR__ . "/.."),
        'cache' => true,
        'log' => array(
            "writer" => array(
                array(
                    "name" => "firephp"
                ),
                array(
                    "name" => "stream",
                    "stream" => __DIR__ . "/../data/log/system.log",
                    "fromat" => array(
                        "name" => "simple",
                        "format" => '%timestamp% %priorityName% (%priority%): %message%' . PHP_EOL
                    ),
                    "filter" => array(
                        "prio" => 6
                    ),
                ),
            ),
            'publicFolder' => realpath(__DIR__ . "/../public")
        ),
    ),
);
