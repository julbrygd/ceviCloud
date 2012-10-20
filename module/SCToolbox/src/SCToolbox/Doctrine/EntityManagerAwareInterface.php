<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Doctrine;
/**
 *
 * @author stephan
 */
interface EntityManagerAwareInterface {
    public function setEntityManager(\Doctrine\ORM\EntityManager $em);
    
    /*
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager();
    
}

?>
