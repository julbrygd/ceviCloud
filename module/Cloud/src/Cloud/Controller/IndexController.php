<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;

class IndexController extends AbstractEntityManagerAwareController {

    public function indexAction() {
        $viewMap = new \Zend\View\Model\ViewModel();
//        $nav = $this->getServiceLocator()->get("Navigation");
//        $m = $nav->getMenu("main");
//        $m->findById("main_Dateien")->setController("file");
//        $nav->saveMenu($m);
//        $viewMap->nav = $m;
        return $viewMap;
    }

    public function fooAction() {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }

}
