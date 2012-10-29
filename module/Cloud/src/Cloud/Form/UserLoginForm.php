<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Form;

use Zend\Form\Form;

use Zend\Form\Element\Collection;

/**
 * Description of UserLoginForm
 *
 * @author stephan
 */
class UserLoginForm extends Form{

    public function __construct() {
        parent::__construct('login');
        $this->setAttribute("action", "/ui/user/login");
        $this->setAttribute("method", "post");
        $this->setInputFilter(new UserLoginInputFilter());
        
        $this->add(array(
            "name"=>"username",
            'attributes'=>array(
                "type"=>"text",
                "id"=>"username"
            ),
            "options"=>array(
                "label"=>"Username"
            )
        ));
        $this->add(array(
            "name"=>"password",
            'attributes'=>array(
                "type"=>"password",
                "id"=>"password"
            ),
            "options"=>array(
                "label"=>"Passwort"
            )
        ));
        $actions = new Collection('actions');
   //     $actions->setAttribute('class', 'form-actions');
        $actions->add(array(
            "name"=>"submit",
            "attributes"=>array(
                "class"=>"btn",
                "type"=>"submit",
                "value"=>"Login"
            )
        ));
        
        $this->add($actions);
    }
}

?>
