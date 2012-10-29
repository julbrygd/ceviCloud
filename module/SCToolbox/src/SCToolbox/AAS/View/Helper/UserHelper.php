<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\AAS\View\Helper;

use \Zend\Form\View\Helper\AbstractHelper;

/**
 * Description of UserHelper
 *
 * @author stephan
 */
class UserHelper extends AbstractHelper{
    /**
     * @var \SCToolbox\AAS\AuthService
     */
    protected static $_auth;
    
    public static function SET_AUTH_SERVICE(\SCToolbox\AAS\AuthService $srv){
        self::$_auth = $srv;
    }

    public function __construct() {
    }

    /**
     * 
     * @return \SCToolbox\AAS\AuthService
     */
    public function __invoke() {
        if(self::$_auth==null)
            self::$_auth = $this;
        return self::$_auth;
    }
    
    public function __call($name, $arguments) {
        return null;
    }

}

?>
