<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\AAS;

use Zend\Permissions\Acl\Acl as ZendAcl;
use SCToolbox\AAS\Entity\Role;
use SCToolbox\AAS\Model\Role as RoleModel;
/** 
 * Description of Acl
 *
 * @author stephan
 */
class Acl {
    
    /**
     * @var \Zend\Permissions\Acl
     */
    protected $_acl;
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;


    function __construct(\Doctrine\ORM\EntityManager $em=null) {
        if($em!=null)
            $this->setEm ($em);
        $this->_acl = new ZendAcl();
        if($this->getEm()!=null)
            $this->init();
    }
    
    public function init(){
        $roles = $this->_em->getRepository('\SCToolbox\AAS\Entity\Role')->findAll();
        $users = $this->_em->getRepository('\SCToolbox\AAS\Entity\User')->findAll();
        foreach ($roles as $role){
            $this->_acl->addRole ($role, $role->getParent());
        }
        foreach ($users as $user){
            $this->_acl->addRole ($user, $user->getRole());
        }
    }

        /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm() {
        return $this->_em;
    }

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->_em = $em;
    }



}

?>
