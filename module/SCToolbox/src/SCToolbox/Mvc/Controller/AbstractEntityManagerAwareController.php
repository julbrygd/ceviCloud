<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Mvc\Controller;
/**
 * Description of AbstractEntityManagerAwareController
 *
 * @author stephan
 */
class AbstractEntityManagerAwareController extends \Zend\Mvc\Controller\AbstractActionController implements \SCToolbox\Doctrine\EntityManagerAwareInterface{
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
