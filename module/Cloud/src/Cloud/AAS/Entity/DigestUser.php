<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\AAS\Entity;

use SCToolbox\AAS\Entity\UserInterface;
use \Doctrine\ORM\Mapping as ORM;

/**
 * Description of User
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @author stephan
 */
class DigestUser implements UserInterface {
    
    protected static $REALM = "cloudDav";
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $uid;
    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $username;
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    /**
     * @ORM\Column(type="string", length=70)
     */
    protected $password;
    /**
     * @ORM\Column(type="string", length=70)
     */
    protected $email;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $activ;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $register;
    /**
     * @ORM\Column(type="string", length=70)
     */
    protected $digest;

    function __construct($username = null, $password = null, $email = null, $activ = null, $register = null) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->activ = $activ;
        $this->register = $register;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $hash = new \PasswordHash(8, false);
        $this->password = $hash->HashPassword($password);
        $this->setDigest($password);
    }

    public function checkPassword($password) {
        $hash = new \PasswordHash(8, false);
        return $hash->CheckPassword($password, $this->password);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getActiv() {
        return $this->activ;
    }

    public function setActiv($activ) {
        $this->activ = $activ;
    }

    public function getRegister() {
        return $this->register;
    }

    public function setRegister($register) {
        $this->register = $register;
    }

    public function getUid() {
        return $this->uid;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDigest() {
        return $this->digest;
    }

    public function setDigest($digest) {
        $this->digest = md5($this->getUsername() . ':' . self::$REALM . ':' . $digest);
    }
    
    public static function getRealm(){
        return self::$REALM;
    }

}

?>
