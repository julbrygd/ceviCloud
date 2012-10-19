<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Cloud\Controller\Index' => 'Cloud\Controller\IndexController',
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
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'cloud' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/ui',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Cloud\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
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
                    "css/bootstrap.min.css",
                    "css/cupertino/jquery-ui-1.9.0.custom.min.css",
                ),
                "baseJS" => array(
                    "js/bootstrap.min.js",
                    "js/jquery-1.8.2.min.js",
                    "js/jquery-ui-1.9.0.min.js",
                ),
            ),
        ),
    ),
);
