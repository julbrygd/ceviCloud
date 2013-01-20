<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Form;

/**
 * Description of UserSettingsValidator
 *
 * @author stephan
 */
class UserSettingsInputFilter extends \Zend\InputFilter\InputFilter {

    public function __construct($zeichen = 6) {
        $passwordMSG = 'Das Passwort muss mindestens ' . $zeichen . ' haben';
        $this->add(
                array(
                    "name" => 'password1',
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

?>
