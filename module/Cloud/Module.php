<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cloud;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements AutoloaderProviderInterface, ConsoleBannerProviderInterface, ConsoleUsageProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        /* @var \Zend\ServiceManager\ServiceManager */
        $sm = $e->getApplication()->getServiceManager();
        /* @var \Doctrine\ORM\EntityManager */
        $em = $sm->get('doctrine.entitymanager.orm_default');
        $em->getEventManager()->addEventListener(\Doctrine\ORM\Events::onFlush, new FileManager\Doctrine\OnFlushListener($sm));
    }

    public function getConsoleBanner(\Zend\Console\Adapter\AdapterInterface $console) {
        return 
        "=========================================\n" .
        "= Welcom to ceviCloud console interface =\n".    
        "=========================================\n";
    }

    public function getConsoleUsage(\Zend\Console\Adapter\AdapterInterface $console) {
        return array(
            "update" => "Updates the Application and the Database",
            "user activate <username>" => "Activate user with username",
            "user activate all" => "Activate all users",
        );
    }
}
