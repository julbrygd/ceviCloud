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
class UserLoginInputFilter extends \Zend\InputFilter\InputFilter {

    public function __construct() {
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
                    "name" => 'password',
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
                                'min' => 3,
                                'encoding' => 'UTF-8',
                                'message' => 'Bitte geben sie mindestens 3 Zeichen ein'
                            )
                        )
                    )
                )
        );
    }

}

?>
