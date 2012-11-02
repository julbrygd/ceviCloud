<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Form;

use Zend\Form\Form;

use Zend\Form\Element\Collection;
use SCToolbox\Form\Element\HTML;
use SCToolbox\Form\Element\Link;

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
        $head = new HTML("header");
        $head->setHtml("<h2>Login</h2>");
        $this->add($head);
        $this->add(array(
            "name"=>"username",
            'attributes'=>array(
                "type"=>"text",
                "id"=>"username",
                "placeholder"=>"Usernamen"
            ),
            "options"=>array(
                "label"=>"Username"
            )
        ));
        $this->add(array(
            "name"=>"password",
            'attributes'=>array(
                "type"=>"password",
                "id"=>"password",
                "placeholder"=>"Passwort"
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
        
        $reg = new Link("reg");
        $reg->setText("Registrieren");
        $reg->setHref("route");
        $reg->setUrlRoute("cloud/register");
        $reg->setAttribute("class", "btn");
        $reg->setAttribute("style", "margin-left:10px");
        
        $actions->add($reg);
        
        $this->add($actions);
        
        
    }
}

?>
