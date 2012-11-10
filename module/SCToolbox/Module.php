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
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Doctrine\DBAL\Types\Type;

class Module implements AutoloaderProviderInterface {

    /**
     *
     * @var SCToolbox\Configuration;
     */
    protected $_config;

    public function init(ModuleManager $moduleManager) {
        $e = $moduleManager->getEventManager();
        $e->attach(MvcEvent::EVENT_ROUTE, array($this, "onRoute"));
    }

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
        Type::addType("permission", 'SCToolbox\Doctrine\Types\Permission');
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, "onRoute"));
        $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, "onRender"));
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
        $this->_config = new Configuration($config);
        $logger = $this->_config->getLogger();
        if ($logger instanceof \Zend\Log\Logger) {
            $e->getApplication()->getServiceManager()->setService("logger", $logger);
        }
        Resources\ResourceModel::CONFIG($this->_config);

        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $serviceManager->setService("SCToolbox/Config", $this->_config);

        $controllerLoader = $serviceManager->get('ControllerLoader');
        $serviceManager->addInitializer(function ($instance) use ($serviceManager) {
                    if (method_exists($instance, 'setEntityManager')) {
                        $instance->setEntityManager($serviceManager->get('doctrine.entitymanager.orm_default'));
                    }
                });

        // Add initializer to Controller Service Manager that check if controllers needs entity manager injection
        $controllerLoader->addInitializer(function ($instance) use ($serviceManager) {
                    if (method_exists($instance, 'setEntityManager')) {
                        $instance->setEntityManager($serviceManager->get('doctrine.entitymanager.orm_default'));
                    }
                });
    }
    
    public function onRender(MvcEvent $e){
        $sm = $e->getApplication()->getServiceManager();
        $nav = $sm->get("Navigation");
        if($e->getViewModel()->terminate()==FALSE)
            $e->getViewModel()->setVariable("SCNav", $nav);
    }

    public function onRoute(MvcEvent $e) {
        $p = $e->getRouteMatch();
        if ($p->getParam("needsAuth", false)) {
            $p->getMatchedRouteName();
            $auth = $e->getApplication()->getServiceManager()->get("SCToolbox\AAS\AuthService");
            $loggedin = $auth->isLoggedin();
            if (!$loggedin) {
                $r = new \Zend\Mvc\Router\Http\RouteMatch(array(
                            "controller" => $this->_config->getAuthController(),
                            "action" => $this->_config->getAuthAction()
                        ));
                $r->setMatchedRouteName(AAS\AuthService::$DEFAULT_LOGIN_ROOTER);
                $e->setRouteMatch($r);
            }
        }
    }

}
