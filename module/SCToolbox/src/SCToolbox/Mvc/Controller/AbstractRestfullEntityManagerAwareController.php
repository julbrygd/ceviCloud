<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Mvc\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use SCToolbox\Doctrine\EntityManagerAwareInterface;
/**
 * Description of AbstractRestfullEntityManagerAwareController
 *
 * @author stephan
 */
abstract class AbstractRestfullEntityManagerAwareController extends AbstractRestfulController implements EntityManagerAwareInterface{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->_em;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $em) {
        return $this->_em = $em;
    }
}

?>
