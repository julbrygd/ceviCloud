<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Form;

use Zend\Form\Form;
use Zend\Form\Element\Collection;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use SCToolbox\Form\Element\HTML;
use SCToolbox\Form\Element\Link;

/**
 * Description of UserSettings
 *
 * @author stephan
 */
class UserSettingsForm extends Form {

    public function __construct() {
        parent::__construct('login');
        $this->setAttribute("action", "/ui/user/settings");
        $this->setAttribute("method", "post");
        
        $this->setInputFilter(new UserSettingsInputFilter());

        $this->add(new \Zend\Form\Element\Csrf("csrf"));
        
        $html = new HTML("pwChangeHead");
        $html->setHtml('<h2>Passwort &auml;ndern</h2>');

        $password1 = new Password("password1");
        $password1->setName("password1")->setLabel("Passwort");

        $password2 = new Password("password2");
        $password2->setName("password2")->setLabel("Passwort wiederholen");
        
        
        $actions = new Collection("actions");
        $submit = new Submit("submit");
        $submit->setAttribute("class", "btn");
        $submit->setValue("Speichern");

        $actions->add($submit);
        
        $this->add($html)->add($password1)->add($password2)->add($actions);
        
    }

}

?>
