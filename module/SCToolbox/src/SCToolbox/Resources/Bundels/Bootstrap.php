<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Resources\Bundels;

use SCToolbox\Resources\Resource;

/**
 * Description of Bootstrap
 *
 * @author stephan
 */
class Bootstrap extends \SCToolbox\Resources\ResourceBundle {
    public function init() {
        $this->_res = array(
            new Resource("bootstrap/bootstrap.min.css", "global", "css"),
            new Resource("bootstrap/bootstrap.min.js", "global", "js")
        );
        $this->_resCDN = array(
            new Resource("http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap-combined.min.css", "cdn", "css"),
            new Resource("http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js", "cdn", "js")
        );
        $this->_depends = array(
            "SCToolbox\Resources\Bundels\JQuery"
        );
    }

}

?>
