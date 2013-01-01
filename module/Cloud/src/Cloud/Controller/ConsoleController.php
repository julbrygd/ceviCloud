<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;
use Zend\Mvc\Exception\RuntimeException;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
/**
 * Description of ConsoleController
 *
 * @author stephan
 */
class ConsoleController extends AbstractEntityManagerAwareController{
    
    public function updateAction() {
        $ret = shell_exec("git fetch origin")."\n";
        $ret .= shell_exec("git reset --hard origin/master")."\n";
        $ret .= "\nNo application updates needed\n";
        return $ret;
    }
    
    public function userAction() {
        
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this controller from a console!');
        }
        return parent::onDispatch($e);
    }

}

?>
