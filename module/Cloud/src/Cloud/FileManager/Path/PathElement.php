<?php

namespace Cloud\FileManager\Path;

/**
 * Description of PathElement
 *
 * @author stephan
 */
class PathElement {
    
    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @var integer
     */
    private $fsoid;
    
    function __construct($name, $fsoid) {
        $this->name = $name;
        $this->fsoid = $fsoid;
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getFsoid() {
        return $this->fsoid;
    }

    public function setFsoid($fsoid) {
        $this->fsoid = $fsoid;
    }

    public function __get($name) {
        switch ($name){
            case "name": return $this->name;break;
            case "id": return $this->fsoid;break;
        }
    }

    public function __set($name, $value) {
        switch ($name){
            case "name": return $this->name=$value;break;
            case "id": return $this->fsoid=$value;break;
        }
    }


}

?>
