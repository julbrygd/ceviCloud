<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cloud\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Collection;
use Zend\Form\Element\Submit;
/**
 * Description of UserRegisterForm
 *
 * @author stephan
 */
class UserRegisterForm extends Form{
    
    public function __construct() {
        parent::__construct("userReister");
        $this->setAttribute("action", "/ui/user/register");
        $this->setAttribute("method", "post");
        $this->setInputFilter(new UserRegisterInputFilter());
        
        $username = new Text("username");
        $username->setName("username")->setLabel("Benutzername");
        
        $name = new Text("name");
        $name->setName("name")->setLabel("Name");
        
        $email = new \Zend\Form\Element\Email("email");
        $email->setName("email")->setLabel("E-Mail Adresse");
        
        $password1 = new Password("password1");
        $password1->setName("password1")->setLabel("Passwort");
        
        $password2 = new Password("password2");
        $password2->setName("password2")->setLabel("Passwort wiederholen");
        
        $actions = new Collection("actions");
        $submit = new Submit("submit");
        $submit->setValue("Registrieren");
        
        $actions->add($submit)->setAttribute('class', 'form-actions');;
        
        $this->add($username)->add($name)->add($email)->add($password1)->add($password2)->add($actions);
    }
}

?>
