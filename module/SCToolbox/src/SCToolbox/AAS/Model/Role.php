<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\AAS\Entity;

use \SCToolbox\AAS\Entity\Role as RoleEntity;
use \Zend\Permissions\Acl\Role\RoleInterface;
/**
 * Description of Role
 *
 * @author stephan
 */
class Role implements RoleInterface{
    
    /**
     * @var \SCToolbox\AAS\Entity\Role
     */
    protected $_role;
    
    function __construct($role) {
        $this->_role = $role;
    }

    public function getRoleId(){
        $this->_role->getRoleId();
    }
    
    public function __call($name, $arguments) {
        if (method_exists($this->_role, $name))
            call_user_func_array(array($this->_role,$name), $arguments);
    }

}

?>
