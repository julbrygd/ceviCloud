<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Resources\Controller\Helper;

use SCToolbox\Resources\ResourceModel;
/**
 * Description of Resources
 *
 * @author stephan
 */
class Resources extends \Zend\Mvc\Controller\Plugin\AbstractPlugin {
    protected $_resourceModel;
    protected $_logger;


    public function __construct() {
        $this->_resourceModel  = ResourceModel::getInstance();
        $this->_logger = \SCToolbox\Log\Logger::getSystemLogger();
    }


    public function __invoke() {
        return $this;
    }
    
    public function addCss($file){
        return $this->add($file, "css");
    }
    
    public function addJs($file){
        return $this->add($file, "js");
    }
    
    public function add($file, $type){
       $module = $this->getActualModule();
       $res = new \SCToolbox\Resources\Resource();
       $res->file = $file;
       $res->module = $module;
       $res->type = $type;
       $this->_resourceModel->add($res);
       return $this;
    }
    
    public function getActualModule() {
         $controller = $this->route->getParam('controller');
         return substr($controller, 0, strpos($controller, "\\"));
    }

}

?>
