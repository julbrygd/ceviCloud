<?php

namespace SCToolbox\Resources\Bundels;

/**
 * Description of Fineupload
 *
 * @author stephan
 */
class Fineupload extends \SCToolbox\Resources\ResourceBundle {

    public function init() {
        $this->_name = "fineupload";
        $baseURI = "fineuploader/";
        $this->_res = array(
            new \SCToolbox\Resources\Resource($baseURI . "fineuploader.css", "global", "css"),
            new \SCToolbox\Resources\Resource($baseURI . "jquery.fineuploader-3.0.js", "global", "js"),
        );
        $this->_resCDN = array(
            new \SCToolbox\Resources\Resource($baseURI . "fineuploader.css", "global", "css"),
            new \SCToolbox\Resources\Resource($baseURI . "jquery.fineuploader-3.0.min.js", "global", "js"),
        );
        $this->_depends = array(
            "SCToolbox\Resources\Bundels\JQuery"
        );
    }
}

?>
