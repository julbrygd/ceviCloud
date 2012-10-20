<?php
return array(
    'controller_plugins' => array(
        'factories' => array(
            'uploader' => function($sm) {
                $plugin = new ZucchiUploader\Controller\Plugin\Uploader();
                $plugin->setOptions($sm->getServiceLocator()->get('zucchiuploader.options'));
                return $plugin;
            }
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'uploader' => function($sm) {
                $helper = new ZucchiUploader\View\Helper\Uploader();
                $helper->setOptions($sm->getServiceLocator()->get('zucchiuploader.options'));
                return $helper;
            }
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'zucchiuploader.options' => function($sm) {
                $config = $sm->get('config');
                $options = new \ZucchiUploader\Options\UploaderOptions();
                if (isset($config['ZucchiUploader'])) {
                    $options->setFromArray($config['ZucchiUploader']);
                }
                return $options;
            }
        ),
    ),
);