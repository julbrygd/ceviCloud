<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager;

use \Zend\ServiceManager\ServiceManagerAwareInterface;
use \SCToolbox\Doctrine\EntityManagerAwareInterface;
use \Zend\ServiceManager\ServiceManager;
use \Doctrine\ORM\EntityManager;
use \Cloud\FileManager\Entity\FileSystemObject;

/**
 * Description of FileManager
 *
 * @author stephan
 */
class FileManager implements ServiceManagerAwareInterface, EntityManagerAwareInterface {

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $_sm;

    /**
     *
     * @var \Cloud\FileManager\Entity\FileSystemObject
     */
    protected $root;

    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $fsoRepo;

    /**
     *
     * @var string
     */
    protected $lastError;

    /**
     *
     * @var string
     */
    protected $tempDir;

    /**
     *
     * @var string
     */
    protected $dataDir;

    /**
     * 
     * @return \Cloud\FileManager\Entity\FileSystemObject
     */
    public function getRoot() {
        if ($this->root == null) {
            //$this->root = $this->getRepo()->findOneBy(array("name" => "ROOT"));
            $this->root = $this->getRepo()->findBy(array("isRootElement" => true));
        }
        return $this->root;
    }

    /**
     * 
     * @return \Cloud\FileManager\Entity\FileSystemObject
     */
    public function find($id) {
        return $this->getRepo()->find($id);
    }

    public function mkdir($name, $parrent = -1) {
        $dir = new FileSystemObject();
        $dir->setName($name);
        $dir->setType(FileSystemObject::$TYPE_FOLDER);
        $dir->setCreated(new \DateTime());
        if ($parrent == -1) {
            $dir->setRootElement(true);
        } else {
            $dir->setRootElement(false);
            $pFso = $this->getRepo()->find($parrent);
            $dir->setParent($pFso);
        }
        $this->getEntityManager()->persist($dir);
        $this->getEntityManager()->flush();
        return true;
    }

    public function renameObject($name, $fsoid) {
        $fso = $this->getRepo()->find($fsoid);
        $fso->setName($name);
        $this->getEntityManager()->persist($fso);
        $this->getEntityManager()->flush();
        return true;
    }

    public function deleteObject($fsoid) {
        /** @var \Cloud\FileManager\Entity\FileSystemObject */
        $fso = $this->getRepo()->find($fsoid);
        if ($fso->hasChildren()) {
            foreach ($fso->getChildren() as $child) {
                $this->deleteObject($child->getFsoid());
            }
        }
        if ($fso->hasMetadata()) {
            $this->getEntityManager()->remove($fso->getMetadata());
        }
        $this->getEntityManager()->remove($fso);
        $this->getEntityManager()->flush();
        return true;
    }

    public function createFile($name, $parentId) {
        $files = $this->find($parentId)->getChildren();
        $fso = null;
        foreach ($files->getIterator() as $file) {
            if ($file->isFile()) {
                if ($file->getName() == $name) {
                    $fso = $file;
                }
            }
        }
        $md5 = md5_file($this->getTempDir() . "/" . $name);
        if ($fso == null) {
            $fso = new FileSystemObject();
            $fso->setParent($this->find($parentId));
            $fso->setName($name);
            $fso->setType(FileSystemObject::$TYPE_FILE);
            $fso->setCreated(new \DateTime());
            $fso->setRootElement(false);
            $fso->getMetadata()->setFolderName($md5);
        }
        $fso->setLastModified(new \DateTime());
        $newname = $this->getDataDir() . "/" . $fso->getMetadata()->getFolderName();
        if (!is_dir($newname)) {
            mkdir($newname, 0755, true);
        }
        $newname .= "/" . $md5;
        rename($this->getTempDir() . "/" . $name, $newname);
        $fso->getMetadata()->setFileName($md5);
        $fso->getMetadata()->setSize(filesize($newname));
        $this->_em->persist($fso);
        $this->_em->flush();
        return;
    }

    public function getLastError() {
        return $this->lastError;
    }

    public function findByPath($path) {
        $pArra = explode("/", $path);
        $fso = null;
        foreach ($pArra as $name) {
            if ($fso == null) {
                $fso = $this->findByName($name);
                if (is_array($fso) && count($fso) == 1) {
                    $fso = $fso[0];
                }
            } else if ($fso instanceof FileSystemObject) {
                $childs = $fso->getChildren();
                foreach ($childs as $child) {
                    if ($child->getName() == $name)
                        $fso = $child;
                }
            }
        }
        return $fso;
    }

    public function findByName($name) {
        return $this->getRepo()->findBy(array("name" => $name));
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepo() {
        if ($this->fsoRepo == null) {
            $em = $this->getEntityManager();
            $this->fsoRepo = $em->getRepository("Cloud\FileManager\Entity\FileSystemObject");
        }
        return $this->fsoRepo;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->_em;
    }

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em) {
        $this->_em = $em;
    }

    /**
     * 
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager) {
        $this->_sm = $serviceManager;
    }

    /**
     * 
     * @return Zend\ServiceManager\ServiceManager;
     */
    public function getServiceManager() {
        return $this->_sm;
    }

    public function setTempDir($tempDir) {
        $this->tempDir = $tempDir;
    }

    public function setDataDir($dataDir) {
        $this->dataDir = $dataDir;
    }

    protected function fileSizeHumanReadable($file, $setup = null) {
        $FZ = ($file && @is_file($file)) ? filesize($file) : NULL;
        $FS = array("B", "kB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");

        if (!$setup && $setup !== 0) {
            return number_format($FZ / pow(1024, $I = floor(log($FZ, 1024))), ($i >= 1) ? 2 : 0) . ' ' . $FS[$I];
        } elseif ($setup == 'INT')
            return number_format($FZ);
        else
            return number_format($FZ / pow(1024, $setup), ($setup >= 1) ? 2 : 0 ) . ' ' . $FS[$setup];
    }

    public function getDataDir() {
        if ($this->dataDir == null) {
            $this->dataDir = getcwd() . "/data/cloud/file";
            if (!is_dir($this->dataDir)) {
                mkdir($this->dataDir, 0755, true);
            }
        }
        return $this->dataDir;
    }

    public function getTempDir() {
        if ($this->tempDir == null) {
            $this->tempDir = getcwd() . "/data/tmp";
            if (!is_dir($this->tempDir)) {
                mkdir($this->tempDir);
            }
            $this->tempDir .= "/" . session_id();
            if (!is_dir($this->tempDir)) {
                mkdir($this->tempDir);
            }
        }
        return $this->tempDir;
    }
    public function rmTempDir() {
        return $this->delTree($this->getTempDir());
    }
    protected function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

}

?>
