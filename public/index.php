<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
include 'init_autoloader.php';

// Run the application!
$app = Zend\Mvc\Application::init(include 'config/application.config.php');
/** @var SCToolbox\Service\ClientType */
$cl = $app->getServiceManager()->get("sctoolbox.clienttype");
if($cl->isWebdav()){
    $dav = $app->getServiceManager()->get("DavService");
    $davServer = $dav->createDavServer();
    $dav->run();
} else {
    $app->run();
}
