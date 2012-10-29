<?php

return array(
    'view_helpers' => array(
        'invokables' => array(
            'res' => '\SCToolbox\Resources\View\Helper\Resources',
            'user' => '\SCToolbox\AAS\View\Helper\UserHelper',
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
);
