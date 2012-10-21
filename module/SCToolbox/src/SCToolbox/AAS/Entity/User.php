<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\AAS\Entity;

use \Doctrine\ORM\Mapping as ORM;
/**
 * Description of User
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @author stephan
 */
class User {
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $uid;
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $username;
    /**
     * @ORM\Column(type="string", length=70)
     */
    protected $password;
    /**
     * @ORM\Column(type="string", length=70)
     */
    protected $email;
}

?>
