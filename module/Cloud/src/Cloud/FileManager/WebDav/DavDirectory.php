<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager\WebDav;

use Sabre\DAV\Collection;
use Doctrine\ORM\EntityManager;
use Cloud\FileManager\Entity\FileSystemObject;
use Cloud\FileManager\FileManager;

/**
 * Description of DavDirectory
 *
 * @author stephan
 */
class DavDirectory extends Collection {

    /**
     *
     * @var \Cloud\FileManager\Entity\FileSystemObject
     */
    protected $fso;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $EM;

    /**
     *
     * @var \Cloud\FileManager\FileManager 
     */
    protected static $FILE_MANAGER;

    public static function setStatic(EntityManager $em, FileManager $fm) {
        self::$EM = $em;
        self::$FILE_MANAGER = $fm;
    }

    function __construct(FileSystemObject $fso) {
        $this->fso = $fso;
    }

    public function getChildren() {
        $ret = array();
        foreach ($this->fso->getChildren() as $child) {
            $tmp = null;
            if ($child->isFolder()) {
                $tmp = new DavDirectory($child);
            } else {
                $tmp = new DavFile($child);
            }
            if ($tmp != null) {
                $ret[] = $tmp;
            }
        }
        return $ret;
    }

    public function getName() {
        return $this->fso->getName();
    }

    public function childExists($name) {
        $childs = $this->fso->getChildren();
        $ret = false;
        foreach ($childs as $child) {
            if ($child->getName() == $name) {
                $ret = true;
            }
        }
        return $ret;
    }

    public function createDirectory($name) {
        return self::$FILE_MANAGER->mkdir($name, $this->fso->getFsoid());
    }

    public function createFile($name, $data = null) {
        $tmp = self::$FILE_MANAGER->getTempDir();
        $tmp .= "/".$name;
        file_put_contents($tmp, $data);
        $parentId = $this->fso->getFsoid();
        $ret = self::$FILE_MANAGER->createFile($name, $parentId);
        self::$FILE_MANAGER->rmTempDir();
        return null;
    }

    public function getChild($name) {
        $childs = $this->fso->getChildren();
        $ret = NULL;
        foreach ($childs as $child) {
            if ($child->getName() == $name) {
                if ($child->isFolder()) {
                    $ret = new DavDirectory($child);
                } else {
                    $ret = new DavFile($child);
                }
            }
        }
        return $ret;
    }

    public function delete() {
        return self::$FILE_MANAGER->deleteObject($this->fso->getFsoid());
    }

    public function getLastModified() {
        return $this->fso->getLastModifiedAsString("U");
    }

    public function setName($name) {
        self::$FILE_MANAGER->renameObject($name, $this->fso->getFsoid());
        return true;
    }

}

?>
