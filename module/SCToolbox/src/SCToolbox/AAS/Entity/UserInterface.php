<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\AAS\Entity;

interface UserInterface{
    public function getUsername();
    public function setUsername($username);
    public function getPassword();
    public function setPassword($password);
}

?>
