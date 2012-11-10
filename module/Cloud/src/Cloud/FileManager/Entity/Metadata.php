<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cloud\FileManager\Entity;
/**
 * Description of Metadata
 *
 * @author stephan
 */
class Metadata {
    /**
     *
     * @var array
     */
    protected $_data = array();
    
    public function __call($name, $arguments) {
        $first = substr($name, 0,3);
        $second = substr($name, 3);
        if($first=="get"){
            return $this->_data[strtolower($second)];
        } else if($first=="set"){
            $this->_data[strtolower($second)] = $arguments;
            return $this;
        }
    }

    public function __get($name) {
        return $this->_data["name"];
    }

    public function __set($name, $value) {
        $this->_data["name"]=$value;
    }

}

?>
