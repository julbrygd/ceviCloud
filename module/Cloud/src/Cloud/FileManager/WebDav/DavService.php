<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager\WebDav;

use Cloud\FileManager\FileManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;
use \Sabre\DAV\Server;
use Cloud\FileManager\WebDav\DavFile;
use Cloud\FileManager\WebDav\DavDirectory;
use Sabre\DAV\Auth\Plugin as AuthPlugin;

/**
 * Description of DavService
 *
 * @author stephan
 */
class DavService implements ServiceLocatorAwareInterface {

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $sl;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @var \Cloud\FileManager\FileManager
     */
    protected $fm;

    /**
     *
     * @var \Sabre\DAV\Server
     */
    protected $server;

    /**
     * @return \Sabre\DAV\Server Dav Server
     */
    public function createDavServer() {
        if ($this->server == null) {
            $this->fm = $this->getServiceLocator()->get("FileManager");
            $this->em = $this->getServiceLocator()->get("doctrine.entitymanager.orm_default");
            DavDirectory::setStatic($this->em, $this->fm);
            DavFile::setStatic($this->em, $this->fm);
            $fsos = $this->fm->getRoot();
            $root = array();
            foreach ($fsos as $fso) {
                $root[] = new DavDirectory($fso);
            }
            $this->server = new Server($root);
            $lockfile = $this->fm->getDataDir()."/lock.dat";
            $lock = new \Sabre\DAV\Locks\Backend\File($lockfile);
            $this->server->addPlugin(new \Sabre\DAV\Locks\Plugin($lock));
            $authBackend = new DigestAuth($this->em, $this->getServiceLocator()->get("SCToolbox\AAS\AuthService"));
            $authPlugin = new AuthPlugin($authBackend, \Cloud\AAS\Entity\DigestUser::getRealm());
            $this->server->addPlugin($authPlugin);
        }
        return $this->server;
    }
    
    public function run(){
        return $this->getServer()->exec();
    }
    
    /**
     * 
     * @return \Sabre\DAV\Server
     */
    public function getServer() {
        if($this->server == null){
            $this->server = $this->createDavServer();
        }
        return $this->server;
    }

    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator() {
        return $this->sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->sl = $serviceLocator;
    }

}

?>
