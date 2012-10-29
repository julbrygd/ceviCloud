<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Resources\View\Helper;
/**
 * Description of Resources
 *
 * @author stephan
 */
class Resources extends \Zend\View\Helper\AbstractHelper{
    /**
     * @var \SCToolbox\Resources\ResourceModel
     */
    protected $_model;


    public function __construct() {
        $this->_model = \SCToolbox\Resources\ResourceModel::getInstance();
    }

    public function __invoke() {
        return $this;
    }
    
    private function toString() {
        $css = $this->_model->css;
        $js  = $this->_model->js;
        $base = $this->getView()->basePath();
        foreach ($css as $res){
            $this->getView()->headLink()->appendStylesheet($base."/".$res->path);
        }
        foreach ($js as $res)
            $this->getView()->headScript()->appendFile($base."/".$res->path);
        $string = $this->getView()->headLink()->toString();
        $string .= "\n" . $this->getView()->headScript()->toString();
        return $string;
    }


    public function __toString() {
        return $this->toString();
    }
}

?>
