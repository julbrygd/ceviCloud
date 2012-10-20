<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Resources;
/**
 * Description of ResourceBundle
 *
 * @author stephan
 */
abstract class ResourceBundle {
    /**
     *
     * @var \SCToolbox\Resources\Resourcre
     */
    protected $_res = array();
    protected $_name;
    protected $_depends = array();
    
    public function __construct() {
        $this->init();
    }

    public abstract function init();

        public function getName(){
        return $this->_name;
    }
    
    public function getDepends(){
        return $this->_depends;
    }
    /**
     * 
     * @return \SCToolbox\Resources\Resourcre
     */
    public function getRes(){
        return $this->_res;
    }
}

?>
