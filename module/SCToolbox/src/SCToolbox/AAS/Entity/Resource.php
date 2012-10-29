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
 * @ORM\Table(name="acl_resource")
 * @author stephan
 */
class Resource {
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $rid;
    
    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $resource;
    
    function __construct($resource=null) {
        $this->resource = $resource;
    }
    public function getResource() {
        return $this->resource;
    }

    public function setResource($resource) {
        $this->resource = $resource;
    }

    public function getRid() {
        return $this->rid;
    }
}

?>
