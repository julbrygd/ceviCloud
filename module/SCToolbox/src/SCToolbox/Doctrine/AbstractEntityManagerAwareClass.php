<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Doctrine;
/**
 * Description of AbstractEntityManagerAwareClass
 *
 * @author stephan
 */
abstract class AbstractEntityManagerAwareClass implements EntityManagerAwareInterface{
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;


    public function setEntityManager(\Doctrine\ORM\EntityManager $em){
        return $this->_em = $em;
    }
    
    /*
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager(){
        return $this->_em;
    }
}

?>
