<?php

return array(
    'router' => array(
        'routes' => array(
            __NAMESPACE__ => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/res',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'ZendSkeletonModule\Controller',
                        'controller' => 'Skeleton',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
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
    'view_helpers' => array(
        'invokables' => array(
            'res' => '\SCToolbox\Resources\View\Helper\Resources',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            // generic view helpers
            'res' => '\SCToolbox\Resources\Helper\Helper\Resources',
        ),
    ),
    'SCToolbox' => array(
        __NAMESPACE__ => array(
            'publicDir' => 'public'
        ),
        "resourceBundels" => array(
            "jquery" => "\SCToolbox\Resources\Bundels\JQuery",
            "jqueryui" => "\SCToolbox\Resources\Bundels\JQueryUI",
            "bootstrap" => "\SCToolbox\Resources\Bundels\Bootstrap",
        ),
    ),
    'di' => array(
        'definition' => array(
            'class' => array(
                'SCToolbox\ResourceModel' => array(
                    'setLogger' => array(
                        'required' => true
                    )
                )
            )
        ),
        'instance' => array(
            'preferences' => array(
                'Zend\Log\LoggerInterface' => 'SCToolbox\Log\Logger'
            )
        )
    )
);
