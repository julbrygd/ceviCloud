<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Form;

/**
 * Description of UserLoginInputFilter
 *
 * @author stephan
 */
class UserRegisterInputFilter extends \Zend\InputFilter\InputFilter {

    public function __construct($zeichen = 6) {
        $passwordMSG = 'Das Passwort muss mindestens ' . $zeichen . ' haben';
        $this->add(
                array(
                    "name" => 'username',
                    "required" => true,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        )
                    ),
                    'validators' => array(
                        array(
                            "name" => 'NotEmpty',
                            'options' => array(
                                'message' => 'Bitte geben sie einen Benutzernamen ein'
                            )
                        ),
                        array(
                            "name" => 'StringLength',
                            'options' => array(
                                'min' => 3,
                                'encoding' => 'UTF-8',
                                'message' => 'Bitte geben sie mindestens 3 Zeichen ein'
                            )
                        )
                    )
                )
        );
        $this->add(
                array(
                    "name" => 'name',
                    "required" => true,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        )
                    ),
                    'validators' => array(
                        array(
                            "name" => 'NotEmpty',
                            'options' => array(
                                'message' => 'Bitte geben sie ihren Namen ein'
                            )
                        ),
                        array(
                            "name" => 'StringLength',
                            'options' => array(
                                'min' => 3,
                                'encoding' => 'UTF-8',
                                'message' => 'Bitte geben sie mindestens 3 Zeichen ein'
                            )
                        )
                    )
                )
        );
        $this->add(
                array(
                    "name" => 'password1',
                    "required" => true,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        )
                    ),
                    'validators' => array(
                        array(
                            "name" => 'NotEmpty',
                            'options' => array(
                                'message' => 'Bitte geben sie ihr Passwort ein'
                            )
                        ),
                        array(
                            "name" => 'StringLength',
                            'options' => array(
                                'min' => $zeichen,
                                'encoding' => 'UTF-8',
                                'message' => $passwordMSG
                            )
                        )
                    )
                )
        );
        $this->add(
                array(
                    "name"=>"email",
                    "required"=>true,
                    'validators'=>array(
                        array(
                            "name"=>"EmailAddress"
                        )
                    )
                )
        );
        $this->add(
                array(
                    "name" => 'password2',
                    "required" => true,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        )
                    ),
                    'validators' => array(
                        array(
                            "name" => 'NotEmpty',
                            'options' => array(
                                'message' => 'Bitte geben sie ihr Passwort ein'
                            )
                        ),
                        array(
                            "name" => 'StringLength',
                            'options' => array(
                                'min' => $zeichen,
                                'encoding' => 'UTF-8',
                                'message' => $passwordMSG
                            )
                        )
                    )
                )
        );
    }

}