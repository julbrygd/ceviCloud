<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ZendSkeletonModule\Controller\Skeleton' => 'ZendSkeletonModule\Controller\SkeletonController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'module-name-here' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/module-specific-root',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'ZendSkeletonModule\Controller',
                        'controller'    => 'Skeleton',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
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
        'template_path_stack' => array(
            'ZendSkeletonModule' => __DIR__ . '/../view',
        ),
    ),
    "SCToolbox" => array(
      "moduleConfig" => array(
          "Cloud" => array(
              "publicPath" => realpath(__DIR__."/../public"),
              "baseCSS" => array(
                  "css/bootstrap.min.css",
                  "css/cupertino/jquery-ui-1.8.24.custom.css",
                  ),
              "baseJS" => array(
                  "js/bootstrap.min.js",
                  "js/jquery-1.8.2.min.js",
                  "js/jquery-ui-1.8.24.min.js",
              ),
          ),
      ) , 
    ),
);
