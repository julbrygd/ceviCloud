<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Cloud\Controller\Index' => 'Cloud\Controller\IndexController',
            'Cloud\Controller\User' => 'Cloud\Controller\UserController',
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
                            ),
                        ),
                    )
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    "SCToolbox" => array(
        "moduleConfig" => array(
            "Cloud" => array(
                "publicPath" => realpath(__DIR__ . "/../public"),
                "baseCSS" => array(
                    "css/style.css"
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
                'paths' => array(realpath(__DIR__."/../src/Cloud/Entity"))
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Cloud' => 'Cloud_Annotation_Driver',
                )
            )
        ),
     ),
);
