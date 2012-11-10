<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;
use Zend\Serializer\Serializer;
use Zend\View\Model\ViewModel;
use Cloud\FileManager\Entity\FileSystemObject;

class FileController extends AbstractEntityManagerAwareController {

    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $fsoRepo;

    public function indexAction() {
        $root = $this->fsoRepo->findBy(array("name" => "ROOT"));
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->fsoRepo = $this->getEntityManager()->getRepository("Cloud\FileManager\Entity\FileSystemObject");
        $this->res()->addCss("css/files.css");
        $this->res()->addJs("js/files.js");
        $this->res()->addBundle("jquerydynatree");
        return parent::onDispatch($e);
    }

    public function folderStructureAction() {
        $base = $this->getRequest()->getQuery("basePath", "/");

        $ret = array(
            array("title" => "Test 1"),
            array("title" => "Test 2",
                "isFolder" => true)
        );
//        $ser = Serializer::factory("json");
//        $res = new ViewModel();
//        $res->ret = $ret;
//        $res->setTerminal(true);
//        \SCToolbox\Log\Logger::getSystemLogger()->dump($res->ret);
//        $this->getResponse()->getHeaders()->addHeaderLine("Content-Type: application/json");
        $res = new \Zend\View\Model\JsonModel($ret);
        return $res;
    }

}

?>
