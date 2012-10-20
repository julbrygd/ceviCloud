<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Resources\Bundels;

/**
 * Description of JQueryUI
 *
 * @author stephan
 */
class JQueryUI extends \SCToolbox\Resources\ResourceBundle {

    public function init() {
        $this->_name = "jqueryui";
        $this->_res = array(
            new \SCToolbox\Resources\Resource("jqueryui/jquery-ui-1.9.0.custom.min.js", "global", "js"),
            new \SCToolbox\Resources\Resource("jqueryui/cupertino/jquery-ui-1.9.0.custom.min.css", "global", "css")
        );
        $this->_resCDN = array(
            new \SCToolbox\Resources\Resource("http://code.jquery.com/ui/1.9.0/jquery-ui.js", "cdn", "js"),
            new \SCToolbox\Resources\Resource("http://code.jquery.com/ui/1.9.0/themes/cupertino/jquery-ui.css", "cdn", "css")
        );
        $this->_depends = array(
            "SCToolbox\Resources\Bundels\JQuery"
        );
    }

}

?>
