<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager\Entity;

/**
 * Description of DynaTreeObject
 *
 * @author stephan
 */
class DynaTreeObject {

    protected $title;
    protected $isFolder;
    protected $isLazy;
    protected $fsoid;

    function __construct($title, $isFolder, $isLazy, $fsoid) {
        $this->title = $title;
        $this->isFolder = $isFolder;
        $this->isLazy = $isLazy;
        $this->fsoid = $fsoid;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getIsFolder() {
        return $this->isFolder;
    }

    public function setIsFolder($isFolder) {
        $this->isFolder = $isFolder;
    }

    public function getIsLazy() {
        return $this->isLazy;
    }

    public function setIsLazy($isLazy) {
        $this->isLazy = $isLazy;
    }

    public function getFsoid() {
        return $this->fsoid;
    }

    public function setFsoid($fsoid) {
        $this->fsoid = $fsoid;
    }


}

?>
