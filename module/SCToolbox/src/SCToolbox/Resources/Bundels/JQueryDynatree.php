<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Resources\Bundels;
/**
 * Description of JQueryDynatree
 *
 * @author stephan
 */
class JQueryDynatree  extends \SCToolbox\Resources\ResourceBundle {

    public function init() {
        $this->_name = "jquerydynatree";
        $skin = "skin-vista";
        if(is_array($this->_options)){
            if(isset($this->_options["skin"]))
                $skin = $this->_options["skin"];
        }
        $this->_res = array(
            new \SCToolbox\Resources\Resource("dynatree/jquery.cookie.js", "global", "js"),
            new \SCToolbox\Resources\Resource("dynatree/".$skin."/ui.dynatree.css", "global", "css"),
            new \SCToolbox\Resources\Resource("dynatree/jquery.dynatree-1.2.2.js", "global", "js"),
        );
        $this->_resCDN = $this->_res;
        $this->_depends = array(
            "SCToolbox\Resources\Bundels\JQuery"
        );
    }
}

?>
