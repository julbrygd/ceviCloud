<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SCToolbox;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e) {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $config = null;
        $moduleConfig = $e->getApplication()->getServiceManager()->get("Configuration");
        $appConfig = $e->getApplication()->getServiceManager()->get("ApplicationConfig");
        if (isset($appConfig["SCToolbox"])) {
            $config = $appConfig["SCToolbox"];
        }
        $config["modulePaths"] = $appConfig["module_listener_options"]["module_paths"];
        $config["modules"] = $appConfig["modules"];
        if (isset($moduleConfig["SCToolbox"]["moduleConfig"])) {
            $config["moduleConfig"] = $moduleConfig["SCToolbox"]["moduleConfig"];
        }
        $c = new Configuration($config);
        $logger = $c->getLogger();
        if($logger instanceof \Zend\Log\Logger){
            $e->getApplication()->getServiceManager()->setService("logger", $logger);           
        }
        Resources\ResourceModel::CONFIG($c);
        
        $app = $e->getApplication();
        $app->getEventManager()->attach('dispatch', array($this, 'renderAssets'), 32);
    }
    
    public function renderAssets(\Zend\Mvc\MvcEvent $e){
        $log = Log\Logger::getSystemLogger();
        $router = $e->getRouteMatch();
        $controller = $router->getParam('controller');
        $module = substr($controller, 0, strpos($controller,"\\"));
        $log->info($module);
        Resources\ResourceModel::getInstance()->setCurrentModule($module);
    }

}
