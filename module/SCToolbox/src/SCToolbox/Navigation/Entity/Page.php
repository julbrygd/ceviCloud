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
 * @ORM\Table(name="navigation_page")
 * @author stephan
 */
class Page {
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer
     */
    protected $pid;
    
    /**
     * ORM\ManyToOne(targetEntity="Menu", inversedBy="pages")
     * ORM\JoinColumn(name="page_menu_id", referencedColumnName="mid")
     */
    protected $menu;
    /**
     *
     * @ORM\Column(type="array")
     */
    protected $page;
    
    public function setPage($page) {
        $this->page = $page;
    }

    public function getPid() {
        return $this->pid;
    }

    public function getPage() {
        return $this->page;
    }

    function __construct($page=null) {
        if(is_array($page))
            $this->page = $page;
        else if($page instanceof \Zend\Navigation\Page\AbstractPage)
            $this->page = $page->toArray();
        else
            $this->page = array();
    }

}

?>
