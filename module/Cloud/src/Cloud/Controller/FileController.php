<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;
use Zend\View\Model\ViewModel;
use \Zend\View\Model\JsonModel;
use Cloud\FileManager\Entity\FileSystemObject;
use Zend\Session\Container;

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

    /**
     * 
     * @var Zend\Session\Container
     */
    protected $session;
    protected static $SESSION_NAME = "Cloud_FileManager";

    public function indexAction() {
        $model = new ViewModel();
        $fsoid = -1;
        if (!isset($_COOKIE["showRoot"]) && isset($_SESSION[self::$SESSION_NAME]["lastFSOID"])) {
            $fsoid = $_SESSION[self::$SESSION_NAME]["lastFSOID"];
            unset($_COOKIE["showRoot"]);
        }
        $model->root = $this->getFsoForHtml($fsoid);
        return $model;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->fsoRepo = $this->getEntityManager()->getRepository("Cloud\FileManager\Entity\FileSystemObject");
        $this->res()->addCss("css/files.css");
        $this->res()->addJs("js/files.js");
        $this->res()->addBundle("jquerydynatree");
        $this->res()->addBundle("fineupload");
        $this->fileManager = $this->getServiceLocator()->get("FileManager");
        $this->fileManager->setDataDir($this->getDataDir());
        $this->fileManager->setTempDir($this->getTempDir());
        return parent::onDispatch($e);
    }

    public function folderStructureAction() {
        $loadFsoid = $this->getRequest()->getQuery("fsoid", 0);
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

    public function showAction() {
        $model = new ViewModel();
        $model->setTerminal(true);
        $fsoid = $this->getEvent()->getRouteMatch()->getParam("fsoid");
        $model->fsos = $this->getFsoForHtml($fsoid);
        return $model;
    }

    public function uploadAction() {
        $uploader = new \SCToolbox\Upload\Fineuploader\FineUploader();
        $fsoid = $uploader->getParameter("actualFsoId");
        $fileName = $uploader->getName();
        $data = $uploader->handleUpload($this->getTempDir());
        $this->fileManager->createFile($fileName, $fsoid);
        $model = new JsonModel($data);
        $this->delTree($this->getTempDir());
        return $model;
    }

    protected function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    protected function getFsoForHtml($fsoid) {
        $_SESSION[self::$SESSION_NAME]["lastFSOID"] = $fsoid;
        $ret = null;
        if ($fsoid != -1) {
            $fso = $this->fileManager->find($fsoid);
            $ret = $fso->getChildren()->toArray();
        } else {
            $ret = $this->getRoot();
        }
        return $ret;
    }

    /**
     * 
     * @return FileSystemObject
     */
    protected function getRoot() {
        //return $this->fsoRepo->findOneBy(array("name" => "ROOT"));
        return $this->fileManager->getRoot();
    }
    
    protected function getDataDir() {
        $dir = getcwd() . "/data/cloud/file";
        if(!is_dir($dir)){
            mkdir($dir, 0755, true);
        }
        return $dir;
    }

    protected function getTempDir() {
        $dir = getcwd() . "/data/tmp";
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $dir .= "/" . session_id();
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        return $dir;
    }

}

?>
