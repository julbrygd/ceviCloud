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
        $path = $this->getEvent()->getRouteMatch()->getParam("path", null);
        if ($path != null) {
            $fso = $this->fileManager->findByPath($path);
            $model->actualFsoid = $fso->getFsoid();
            if ($this->getRequest()->isPost()) {
                $model->setTerminal(true);
                $model->setTemplate('show');
                $model->currentFso = $fso;
                $model->fsos = $fso->getChildren()->toArray();
            } else {
                $model->currentFso = $fso;
                $model->root = $fso->getChildren()->toArray();
            }
        } else {
            $model->root = $this->getFsoForHtml($fsoid);
            $model->actualFsoid = -1;
        }
        return $model;
    }

    public function downloadAction() {
        $path = $this->getEvent()->getRouteMatch()->getParam("path", null);       
        $model = new ViewModel();
        $model->setTerminal(true);
        if ($path != null) {
            $fso = $this->fileManager->findByPath($path);
            if($fso instanceof FileSystemObject){
                $dataPath = $this->fileManager->getDataDir();
                $file = $dataPath . "/" .$fso->getMetadata()->getFolderName();
                $file .= "/" . $fso->getMetadata()->getFileName();
                $mimeType = mime_content_type($file);
                $name = $fso->getName();
                $now = new \DateTime("now", new \DateTimeZone("GMT"));
                $this->getResponse()->getHeaders()->addHeaderLine('Content-Description: File Transfer');
                $this->getResponse()->getHeaders()->addHeaderLine('Content-Type: '.$mimeType);
                $this->getResponse()->getHeaders()->addHeaderLine('Content-Disposition: attachment; filename='.$name);
                $this->getResponse()->getHeaders()->addHeaderLine('Content-Transfer-Encoding: binary');
                $this->getResponse()->getHeaders()->addHeaderLine('Expires: '. $now->format("r"));
                $this->getResponse()->getHeaders()->addHeaderLine('Cache-Control: must-revalidate');
                $this->getResponse()->getHeaders()->addHeaderLine('Pragma: public');
                $this->getResponse()->getHeaders()->addHeaderLine('Content-Length: '.filesize($file));
                $model->filename = $file;
            }
        }
        return $model;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->fsoRepo = $this->getEntityManager()->getRepository("Cloud\FileManager\Entity\FileSystemObject");
        $this->res()->addCss("css/files.css");
        $this->res()->addJs("js/files.js");
        $this->res()->addBundle("jquerydynatree");
        $this->res()->addBundle("fineupload");
        $this->fileManager = $this->getServiceLocator()->get("FileManager");
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
        $data = $uploader->handleUpload($this->fileManager->getTempDir());
        $this->fileManager->createFile($fileName, $fsoid);
        $model = new JsonModel($data);
        $this->delTree($this->fileManager->getTempDir());
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

    

}

?>
