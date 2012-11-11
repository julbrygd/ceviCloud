<?php

return array(
    'view_helpers' => array(
        'invokables' => array(
            'res' => '\SCToolbox\Resources\View\Helper\Resources',
            'user' => '\SCToolbox\AAS\View\Helper\UserHelper',
            'bootstrapForm' => '\SCToolbox\Form\View\Helper\BootstrapForm',
            'scLinkElement' => '\SCToolbox\Form\View\Helper\ElementLink',
            'form_element' => '\SCToolbox\Form\View\Helper\FormElement',
            'SubMenu' => '\SCToolbox\Navigation\View\Helper\SubMenu',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'res' => '\SCToolbox\Resources\Controller\Helper\Resources',
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
    'service_manager' => array(
        'factories' => array(
            'SCToolbox\AAS\AuthService' => function(Zend\ServiceManager\ServiceManager $sl) {
                $em = $sl->get('doctrine.entitymanager.orm_default');
                $a = new SCToolbox\AAS\AuthService($em);
                return $a;
            },
        ),
        'invokables' => array(
            'Navigation' => '\SCToolbox\Navigation\Navigation',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'SCToolbox_Annotation_Driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(realpath(__DIR__ . "/../src/SCToolbox/AAS/Entity"),
                    realpath(__DIR__ . "/../src/SCToolbox/Navigation/Entity"))
            ),
            'orm_default' => array(
                'drivers' => array(
                    'SCToolbox' => 'SCToolbox_Annotation_Driver',
                )
            )
        ),
    ),
);
