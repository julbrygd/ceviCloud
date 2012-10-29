<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\AAS\Entity;

use \SCToolbox\AAS\Entity\User as UserEntity;
use \Zend\Permissions\Acl\Role\RoleInterface;
/**
 * Description of Role
 *
 * @author stephan
 */
class User implements RoleInterface{
    /**
     * @var \SCToolbox\AAS\Entity\User
     */
    protected $_user;
    
    function __construct($user) {
        $this->$_user = $user;
    }

    public function getRoleId(){
        $this->_user->getUsername();
    }
    
    public function __call($name, $arguments) {
        if (method_exists($this->_user, $name))
            call_user_func_array(array($this->_user,$name), $arguments);
    }
}

?>
