<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager\WebDav;

use Sabre\DAV\File;
use Doctrine\ORM\EntityManager;
use Cloud\FileManager\Entity\FileSystemObject;

/**
 * Description of DavFile
 *
 * @author stephan
 */
class DavFile extends File {

    /**
     *
     * @var \Cloud\FileManager\Entity\FileSystemObject
     */
    protected $fso;

    /**
     *
     * @var string‡
     */
    protected $filename;

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
        return null;
    }

    public function getName() {
        return $this->fso->getName();
    }

    public function get() {
        return fopen($this->getFileName(), "r");
    }

    public function getContentType() {
        return mime_content_type($this->getFileName());
    }

    public function getETag() {
        return md5_file($this->getFileName());
    }

    public function getSize() {
        return filesize($this->getFileName());
    }

    public function put($data) {
        $tmp = self::$FILE_MANAGER->getTempDir();
        $tmp .= "/".$this->getName();
        file_put_contents($tmp, $data);
        $parentId = $this->fso->getParent()->getFsoid();
        $ret = self::$FILE_MANAGER->createFile($this->getName(), $parentId);
        self::$FILE_MANAGER->rmTempDir();
        return true;
    }

    public function delete() {
        return self::$FILE_MANAGER->deleteObject($this->fso->getFsoid());
    }

    public function getLastModified() {
        return $this->fso->getLastModifiedAsString("U");
    }

    public function setName($name) {
        return self::$FILE_MANAGER->renameObject($name, $this->fso->getFsoid());;
    }

    protected function getFileName() {
        if ($this->filename == null) {
            $file = self::$FILE_MANAGER->getDataDir();
            $file .= "/";
            $file .= $this->fso->getMetadata()->getFolderName();
            $file .= "/";
            $file .= $this->fso->getMetadata()->getFileName();
            $this->filename = $file;
        }
        return $this->filename;
    }

}

?>
