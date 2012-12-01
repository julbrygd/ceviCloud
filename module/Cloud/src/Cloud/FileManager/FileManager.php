<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager;

use \Zend\ServiceManager\ServiceManagerAwareInterface;
use \SCToolbox\Doctrine\EntityManagerAwareInterface;
use \Zend\ServiceManager\ServiceManager;
use \Doctrine\ORM\EntityManager;
use \Cloud\FileManager\Entity\FileSystemObject;

/**
 * Description of FileManager
 *
 * @author stephan
 */
class FileManager implements ServiceManagerAwareInterface, EntityManagerAwareInterface {

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $_sm;

    /**
     *
     * @var \Cloud\FileManager\Entity\FileSystemObject
     */
    protected $root;

    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $fsoRepo;

    /**
     *
     * @var string
     */
    protected $lastError;

    /**
     * 
     * @return \Cloud\FileManager\Entity\FileSystemObject
     */
    public function getRoot() {
        if ($this->root == null) {
            //$this->root = $this->getRepo()->findOneBy(array("name" => "ROOT"));
            $this->root = $this->getRepo()->findBy(array("isRootElement" => true));
        }
        return $this->root;
    }

    /**
     * 
     * @return \Cloud\FileManager\Entity\FileSystemObject
     */
    public function find(\int $id) {
        return $this->getRepo()->find($id);
    }

    public function mkdir($name, $parrent = -1) {
        $dir = new FileSystemObject();
        $dir->setName($name);
        $dir->setType(FileSystemObject::$TYPE_FOLDER);
        $dir->setCreated(new \DateTime());
        if ($parrent == -1) {
            $dir->setRootElement(true);
        }
        
        $this->getEntityManager()->persist($dir);
        $this->getEntityManager()->flush();
        return true;
    }
    
    public function renameObject($name, $fsoid){
        $fso = $this->getRepo()->find($fsoid);
        $fso->setName($name);
        $this->getEntityManager()->persist($fso);
        $this->getEntityManager()->flush();
        return true;
    }
    
    public function deleteObject($fsoid){
        /** @var \Cloud\FileManager\Entity\FileSystemObject */
        $fso = $this->getRepo()->find($fsoid);
        if($fso->hasChildren()){
            foreach($fso->getChildren() as $child){
                $this->deleteObject($child->getFsoid());
            }
        } else {
            $this->getEntityManager()->remove($fso);
            $this->getEntityManager()->flush();
        }
        return true;
    }

    public function getLastError() {
        return $this->lastError;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepo() {
        if ($this->fsoRepo == null) {
            $em = $this->getEntityManager();
            $this->fsoRepo = $em->getRepository("Cloud\FileManager\Entity\FileSystemObject");
        }
        return $this->fsoRepo;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->_em;
    }

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em) {
        $this->_em = $em;
    }

    /**
     * 
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager) {
        $this->_sm = $serviceManager;
    }

    /**
     * 
     * @return Zend\ServiceManager\ServiceManager;
     */
    public function getServiceManager() {
        return $this->_sm;
    }

}

?>
