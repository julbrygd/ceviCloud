<?php

namespace Cloud\FileManager\Path;

/**
 * Description of Path
 *
 * @author stephan
 */
class Path {

    /**
     *
     * @var array
     */
    protected $elements;

    function __construct() {
        $this->elements = array();
    }

    public function insertFirst($name, $id=null) {
        if($name instanceof PathElement){
            array_unshift($this->elements, $name);
        } else {
            array_unshift($this->elements, new PathElement($name, $id));
        }
        return $this;
    }
    
    public function append($name, $id=null) {
        if($name instanceof PathElement){
            array_push($this->elements, $name);
        } else {
            array_push($this->elements, new PathElement($name, $id));
        }
        return $this;
    }
    
    public function getElement($index=null){
        if($index==null){
            return $this->elements;
        } else if(isset ($this->elements[$index])) {
            return $this->elements[$index];
        } else {
            return null;
        }
    }
    
    public function getIdPath($startingSlash=true, $insertStringBeforName=""){
        $ret = "";
        foreach ($this->elements as $element){
            $ret .= $insertStringBeforName.$element->id . "/";
        }
        $ret = trim($ret, "/");
        if($startingSlash){
            $ret = "/".$ret;
        }
        return $ret;
    }

    public function __toString() {
        return $this->toString();
    }

    public function toString($startingSlash=true) {
        $ret = "";
        foreach ($this->elements as $element){
            $ret .= $element->name . "/";
        }
        $ret = trim($ret, "/");
        if($startingSlash){
            $ret = "/".$ret;
        }
        return $ret;
    }

}

?>
