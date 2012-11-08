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
 * @ORM\Table(name="role")
 * @author stephan
 */
class Role implements RoleInterface{
    
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $rid;
    
    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Role", mappedBy="parent")
     */
    protected $children;
    
    /** 
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="children") 
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="rid")
     */
    protected $parent;


    function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getChildren() {
        return $this->children;
    }

    public function setChildren($children) {
        $this->children = $children;
    }

        
    public function getRid() {
        return $this->rid;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @return null|\SCToolbox\AAS\Entity\Role
     */
    public function getParent() {
        if($this->parent==null)
            return null;
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }
        
    public function getRoleId(){
        return "role_".$this->name;
    }
    
    public function __toString() {
        return $this->name;
    }
}

?>
