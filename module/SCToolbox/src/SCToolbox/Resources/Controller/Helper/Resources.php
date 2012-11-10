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
class Resources extends \Zend\Mvc\Controller\Plugin\AbstractPlugin implements \Zend\ServiceManager\ServiceManagerAwareInterface{

    protected $_resourceModel;
    protected $_logger;
    
    /**
     *
     * @var \Zend\ServiceManager\ServiceManager 
     */
    protected $_sm;

    public function __construct() {
        $this->_resourceModel = ResourceModel::getInstance();
        $this->_logger = \SCToolbox\Log\Logger::getSystemLogger();
    }

    public function __invoke() {
        return $this;
    }

    public function addCss($file, $module = null) {
        return $this->add($file, "css", $module);
    }

    public function addJs($file, $module = null) {
        return $this->add($file, "js", $module);
    }

    public function add($file, $type, $module = null) {
        if ($module == null)
            $module = $this->getActualModule();
        $res = new \SCToolbox\Resources\Resource();
        $res->file = $file;
        $res->module = $module;
        $res->type = $type;
        $this->_resourceModel->add($res);
        return $this;
    }
    
    public function addBundle($name){
        $this->_resourceModel->addBundle($name);
    }

    public function getActualModule() {
        $controller = get_class($this->getController());
        return strtolower(substr($controller, 0, strpos($controller, "\\")));
    }
    
    /**
     * 
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager(){
        return $this->_sm;
    }

    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
        $this->_sm = $serviceManager;
    }

}

?>
