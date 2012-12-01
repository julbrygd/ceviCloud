<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;
use Zend\Serializer\Serializer;
use Zend\View\Model\ViewModel;
use \Zend\View\Model\JsonModel;
use Cloud\FileManager\Entity\FileSystemObject;

class FileController extends AbstractEntityManagerAwareController {

    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $fsoRepo;

    /**
     *
     * @var \Cloud\FileManager\FileManager
     */
    protected $fileManager;

    public function indexAction() {
        $root = $this->getRoot();
        $model = new ViewModel();
        $model->root = $root;
        return $model;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->fsoRepo = $this->getEntityManager()->getRepository("Cloud\FileManager\Entity\FileSystemObject");
        $this->res()->addCss("css/files.css");
        $this->res()->addJs("js/files.js");
        $this->res()->addBundle("jquerydynatree");
        $this->fileManager = $this->getServiceLocator()->get("FileManager");
        return parent::onDispatch($e);
    }

    public function folderStructureAction() {
        $loadFsoid = $this->getRequest()->getQuery("fsoid", 0);
        \SCToolbox\Log\Logger::getSystemLogger()->info("FSOID: " . $loadFsoid);
        $fso = null;
        if ($loadFsoid == 0) {
            $fso = $this->getRoot();
            $ret = array();
            foreach ($fso as $item) {
                if ($item instanceof FileSystemObject)
                    $ret[] = $item->toDynaTreeArray();
            }
        } else {
            $fso = $this->fileManager->find($loadFsoid);
            $ret = $fso->childsToDynaTreeArray();
        }
        $res = new \Zend\View\Model\JsonModel($ret);
        return $res;
    }

    public function createFolderAction() {
        $model = new JsonModel();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($this->fileManager->mkdir($data["name"], $data["fsoid"])) {
                $model->error = false;
            } else {
                $model->error = true;
                $model->message = $this->fileManager->getLastError();
            }
        }
        return $model;
    }

    public function renameAction() {
        $model = new JsonModel();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($this->fileManager->renameObject($data["name"], $data["fsoid"])) {
                $model->error = false;
            } else {
                $model->error = true;
                $model->message = $this->fileManager->getLastError();
            }
        }
        return $model;
    }
    
    public function deleteAction() {
        $model = new JsonModel();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($this->fileManager->deleteObject($data["fsoid"])) {
                $model->error = false;
            } else {
                $model->error = true;
                $model->message = $this->fileManager->getLastError();
            }
        }
        return $model;
    }

    /**
     * 
     * @return FileSystemObject
     */
    protected function getRoot() {
        //return $this->fsoRepo->findOneBy(array("name" => "ROOT"));
        return $this->fileManager->getRoot();
    }

}

?>
