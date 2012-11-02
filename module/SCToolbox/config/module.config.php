<?php

return array(
    'view_helpers' => array(
        'invokables' => array(
            'res' => '\SCToolbox\Resources\View\Helper\Resources',
            'user' => '\SCToolbox\AAS\View\Helper\UserHelper',
            'bootstrapForm' => '\SCToolbox\Form\View\Helper\BootstrapForm',
            'scLinkElement' => '\SCToolbox\Form\View\Helper\ElementLink',
            'form_element' => '\SCToolbox\Form\View\Helper\FormElement',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'res' => '\SCToolbox\Resources\View\Helper\Resources',
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
            'ACL' => function($serviceManger){
                $em = $serviceManger->get("doctrine.entitymanager.orm_default");
                $acl = new \SCToolbox\AAS\Acl($em);
                return $acl;
            }
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
    ),
    'doctrine' => array(
        'driver' => array(
            'SCToolbox_Annotation_Driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(realpath(__DIR__."\..\src\SCToolbox\AAS\Entity\\"))
            ),
            'orm_default' => array(
                'drivers' => array(
                    'SCToolbox' => 'SCToolbox_Annotation_Driver',
                )
            )
        ),
     ),
);
