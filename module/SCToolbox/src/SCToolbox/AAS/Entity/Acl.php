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
 * @ORM\Table(name="acl")
 * @author stephan
 */
class Acl {

    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $aid;
    
    /** 
     * @ORM\ManyToOne(targetEntity="Resource") 
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="rid")
     */
    protected $resource;
    
    /**
     * @ORM\Column(type="permission")
     */
    protected $permission;
    
    public function getAid() {
        return $this->aid;
    }

    public function getResource() {
        return $this->resource;
    }

    public function setResource($resource) {
        $this->resource = $resource;
    }

    public function getPermission() {
        return $this->permission;
    }

    public function setPermission($permission) {
        $this->permission = $permission;
    }

    public function setAllowed(){
        $this->setPermission("allow");
    }
    
    public function setDeny(){
        $this->setPermission("deny");
    }

}

?>
