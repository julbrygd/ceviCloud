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
class FileManager implements ServiceManagerAwareInterface, EntityManagerAwareInterface{
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
     * @return \Cloud\FileManager\Entity\FileSystemObject
     */
    public function getRoot() {
        if($this->root == null){
            $this->root = $this->getRepo()->findOneBy(array("name" => "ROOT"));
        }
        return $this->root;
    }
    
    /**
     * 
     * @return \Cloud\FileManager\Entity\FileSystemObject
     */
    public function find(int $id) {
        return $this->getRepo()->find($id);
    }
    
    /**
     * 
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepo(){
        if($this->fsoRepo == null){
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
    public function getServiceManager(){
        return $this->_sm;
    }
}

?>
