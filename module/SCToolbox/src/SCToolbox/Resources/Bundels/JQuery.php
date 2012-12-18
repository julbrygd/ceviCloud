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
class JQuery extends \SCToolbox\Resources\ResourceBundle {

    public function init() {
        $this->_res = array(
            new \SCToolbox\Resources\Resource("jquery/jquery-1.8.2.min.js", "global", "js"),
            new \SCToolbox\Resources\Resource("dynatree/jquery.cookie.js", "global", "js"),
            new \SCToolbox\Resources\Resource("jquery/jquery.history.js", "global", "js"),
        );
        $this->_resCDN = array(
            new \SCToolbox\Resources\Resource("dynatree/jquery.cookie.js", "global", "js"),
            new \SCToolbox\Resources\Resource("http://code.jquery.com/jquery-1.8.2.js", "cdn", "js"),
            new \SCToolbox\Resources\Resource("jquery/jquery.history.js", "global", "js"),
        );
    }

}

?>
