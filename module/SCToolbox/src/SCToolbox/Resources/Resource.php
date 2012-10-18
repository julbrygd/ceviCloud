<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Resources;

/**
 * Description of Resource
 *
 * @author CONST
 */
class Resource {
    protected $filename;
    protected $module;
    protected $type;
    
    public function __get($name){
        $ret = "";
        switch($name){
            case "file": $ret = $this->filename;break;
            case "module": $ret = $this->module;break;
            case "type": $ret = $this->type;break;
        }
        return $ret;
    }
    
    public function __set($name, $value){
        switch($name){
            case "file": $this->filename = $value;break;
            case "module": $this->module = $value;break;
            case "type": 
                if(in_array($value, ResourceModel::getInstance()->getResType()))
                    $this->type = $value;
                break;
        }
    }
}

?>
