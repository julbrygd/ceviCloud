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
use Zend\Form\Element\Captcha;

/**
 * Description of UserRegisterForm
 *
 * @author stephan
 */
class UserRegisterForm extends Form {

    public function __construct($reCaptcah) {
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
        
        $re = new \Zend\Captcha\ReCaptcha();
        $re->setPrivkey($reCaptcah["privKey"])->setPubkey($reCaptcah["pubKey"]);
        $re->setOption("theme", $reCaptcah["theme"]);
        $re->setOption("lang", $reCaptcah["lang"]);
        $captcha = new Captcha('captcha');
        $captcha
                ->setCaptcha($re)
                ->setLabel('Please verify you are human');

        $actions = new Collection("actions");
        $submit = new Submit("submit");
        $submit->setAttribute("class", "btn");
        $submit->setValue("Registrieren");

        $actions->add($submit);
        ;

        $this->add($username)->add($name)->add($email)->add($password1)->add($password2)->add($captcha)->add($actions);
    }

}

?>
