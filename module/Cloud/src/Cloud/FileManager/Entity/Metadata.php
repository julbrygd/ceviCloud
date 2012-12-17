<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager\Entity;

use \Doctrine\ORM\Mapping as ORM;

/**
 * Description of Metadata object for FSO
 * @ORM\Entity
 * @ORM\Table(name="file_filemetadata")
 * @author stephan
 */
class Metadata extends \SCToolbox\Doctrine\ArrayAccessEntity {

    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $mid;

    /**
     * @ORM\OneToOne(targetEntity="FileSystemObject", inversedBy="metadata")
     * @ORM\JoinColumn(name="filesystemobject_id", referencedColumnName="fsoid")
     * */
    protected $fsoid;

    /**
     * @ORM\Column(type="string")
     */
    protected $folderName;

    /**
     * @ORM\Column(type="string")
     */
    protected $fileName;

    /**
     * @ORM\Column(type="integer")
     */
    protected $size;

    public function getFolderName() {
        return $this->folderName;
    }

    public function setFolderName($folderName) {
        $this->folderName = $folderName;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function getSize() {
        return $this->size;
    }

    public function getSizeAsString() {
        return $this->fileSizeHumanReadable($this->size);
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getMid() {
        return $this->mid;
    }

    public function getFsoid() {
        return $this->fsoid;
    }
    
    public function setFsoid($fsoid) {
        $this->fsoid = $fsoid;
    }

    
    protected function fileSizeHumanReadable($size) {
        if ($size < 1024)
            return $size . ' B';
        elseif ($size < 1048576)
            return round($size / 1024, 2) . ' KB';
        elseif ($size < 1073741824)
            return round($size / 1048576, 2) . ' MB';
        elseif ($size < 1099511627776)
            return round($size / 1073741824, 2) . ' GB';
        else
            return round($size / 1099511627776, 2) . ' TB';
    }

}

?>
