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

    protected $_res = array();
    protected $_resCDN = array();
    protected $_depends = array();
    protected $_options = array();

    public function __construct($options = null) {
        $this->_options = $options;
        $this->init();
    }

    public abstract function init();

    public function getResCDN() {
        return $this->_resCDN;
    }

    public function getDepends() {
        return $this->_depends;
    }

    public function getRes() {
        return $this->_res;
    }

    public function getOptions() {
        return $this->_options;
    }

    public function setOptions($options) {
        $this->_options = $options;
    }

}

?>
