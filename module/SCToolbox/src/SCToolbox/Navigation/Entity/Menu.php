<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Navigation\Entity;
use \Doctrine\ORM\Mapping as ORM;

/**
 * Description of User
 * @ORM\Entity
 * @ORM\Table(name="navigation_menu")
 * @author stephan
 */
class Menu {
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer
     */
    protected $mid;
    
    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $name;
    
    /**
     *
     * ORM\OneToMany(targetEntity="Page", mappedBy="menu")
     * @ORM\Column(type="array")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $pages;
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPages() {
        return $this->pages;
    }

    public function setPages($pages) {
        $this->pages = $pages;
    }

    
    public function getMid() {
        return $this->mid;
    }

    function __construct() {
        //$this->pages =  new \Doctrine\Common\Collections\ArrayCollection();
    }

}

?>
