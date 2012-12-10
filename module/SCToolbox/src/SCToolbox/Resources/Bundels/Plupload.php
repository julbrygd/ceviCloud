<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Resources\Bundels;

/**
 * Description of JQuery
 *
 * @author stephan
 */
class Plupload extends \SCToolbox\Resources\ResourceBundle {

    public function init() {
        $this->_name = "plupload";
        $baseURI = "plupload/js/";
        $this->_res = array(
            new \SCToolbox\Resources\Resource($baseURI."jquery.ui.plupload/css/jquery.ui.plupload.css", "global", "css"),
            new \SCToolbox\Resources\Resource($baseURI."plupload.full.js", "global", "js"),
            new \SCToolbox\Resources\Resource($baseURI."jquery.ui.plupload/jquery.ui.plupload.js", "global", "js"),
        );
        $this->_resCDN = $this->_res;
        $this->_depends = array(
            "SCToolbox\Resources\Bundels\JQuery"
        );
    }

}

?>