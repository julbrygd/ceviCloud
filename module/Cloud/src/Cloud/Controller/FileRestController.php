<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractRestfullEntityManagerAwareController;
/**
 * Description of FileRestController
 *
 * @author stephan
 */
class FileRestController extends AbstractRestfullEntityManagerAwareController{
    public function create($data) {
        $this->getEntityManager()->getEventManager()->addEventListener($events, $listener)
    }

    public function delete($id) {
        
    }

    public function get($id) {
        
    }

    public function getList() {
        return array(
            array("rest"=>"test")
        );
    }

    public function update($id, $data) {
        
    }
}

?>
