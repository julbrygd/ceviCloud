<?php

return array(
    'view_helpers' => array(
        'invokables' => array(
            'pathList' => 'Cloud\FileManager\View\Helper\PathList'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Cloud\Controller\Index' => 'Cloud\Controller\IndexController',
            'Cloud\Controller\User' => 'Cloud\Controller\UserController',
            'Cloud\Controller\File' => 'Cloud\Controller\FileController',
            'Cloud\Controller\Console' => 'Cloud\Controller\ConsoleController',
            'Cloud\Controller\Settings'=> 'Cloud\Controller\SettingsController',
            'Cloud\Controller\Filerest' => 'Cloud\Controller\FileRestController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Cloud\Controller\Index',
                        'action' => 'index',
                        'needsAuth' => true,
                        'layout' => 'cloud/layout/layout',
                    ),
                ),
            ),
            'cloud' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/ui',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Cloud\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                        'needsAuth' => true,
                        'layout' => 'cloud/layout/layout',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'showFile' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/file/show/[:fsoid]',
                            'constraints' => array(
                                'fsoid' => '[0-9]*',
                            ),
                            'defaults' => array(
                                'controller' => 'file',
                                'action' => 'show',
                            ),
                        ),
                    ),
                    'showPaht' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/file/path/[:path]',
                            'constraints' => array(
                                'path' => '[[a-zA-Z].*',
                            ),
                            'defaults' => array(
                                'controller' => 'file',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'downloadFile' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/file/download/[:path]',
                            'constraints' => array(
                                'path' => '[[a-zA-Z].*',
                            ),
                            'defaults' => array(
                                'controller' => 'file',
                                'action' => 'download',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/user/register',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Cloud\Controller',
                                'controller' => 'User',
                                'action' => 'register',
                                'needsAuth' => false,
                            )
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/user/logout',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Cloud\Controller',
                                'controller' => 'User',
                                'action' => 'logout',
                            )
                        ),
                    ),
                    "userActivate" => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user/activate[/username[/:username[/key[/:key]]]]',
                            'constraints' => array(
                                'controller' => "user",
                                'action' => 'activate',
                                'username' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'key' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => "user",
                                'action' => 'activate',
                                'needsAuth' => false,
                            ),
                        ),
                    )
                ),
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'update' => array(
                    'type' => 'simple',
                    'options' => array(
                        'route' => 'update',
                        'defaults' => array(
                            '__NAMESPACE__' => 'Cloud\Controller',
                            'controller' => 'Console',
                            'action' => 'update',
                        )
                    )
                ),
                'userActivate' => array(
                    'options' => array(
                        'route' => 'user activate <user>',
                        'defaults' => array(
                            '__NAMESPACE__' => 'Cloud\Controller',
                            'controller' => 'Console',
                            'action' => 'user',
                        )
                    )
                ),
            )
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'cloud/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'show' => __DIR__ . '/../view/cloud/file/show.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    "SCToolbox" => array(
        "AAS" => array(
            "userClass" => 'Cloud\AAS\Entity\DigestUser',
            "userProperty" => 'username',
            "passwordProperty" => 'password',
        ),
        "moduleConfig" => array(
            "Cloud" => array(
                "publicPath" => realpath(__DIR__ . "/../public"),
                "baseCSS" => array(
                    "css/style.css"
                ),
                'baseJS' => array(
                    'js/cloud.js'
                ),
                "resourceBundles" => array(
                    "jqueryui",
                    "bootstrap"
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'Cloud_Annotation_Driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    realpath(__DIR__ . "/../src/Cloud/FileManager/Entity"),
                    realpath(__DIR__ . "/../src/Cloud/AAS/Entity")
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Cloud' => 'Cloud_Annotation_Driver',
                )
            )
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'FileManager' => '\Cloud\FileManager\FileManager',
            'DavService' => '\Cloud\FileManager\WebDav\DavService'
        ),
    ),
);
