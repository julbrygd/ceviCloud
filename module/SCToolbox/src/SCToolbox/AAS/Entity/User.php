<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\AAS\Entity;

use \Doctrine\ORM\Mapping as ORM;

use \Zend\Permissions\Acl\Role\RoleInterface;
/**
 * Description of User
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @author stephan
 */
class User{
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
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="rid")
     */
    protected $role;


    function __construct($username=null, $password=null, $email=null, $activ=null, $register=null) {
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
    }
    
    public function checkPassword($password){
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
    
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getRoleId() {
        return "user_".$this->username;
    }
}

?>
