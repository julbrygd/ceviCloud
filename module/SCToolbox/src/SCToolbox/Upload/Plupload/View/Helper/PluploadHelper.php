<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Upload\Plupload\View\Helper;

use \Zend\View\Helper\AbstractHelper;
use \Zend\Serializer\Adapter\Json;

/**
 * Description of PluploadHelper
 *
 * @author stephan
 */
class PluploadHelper extends AbstractHelper {

    public function __invoke($url, $id, $options = array()) {

        $view = $this->getView();
        $serializer = new Json();

        $defaultRuntimes = "html5,silverlight,flash,html4";
        if (!isset($options["runtimes"]))
            $options["runtimes"] = $defaultRuntimes;
        $optionDefaults = array(
            "max_file_size" => "10mb",
            "chunk_size" => '1mb',
            "unique_names" => true,
            "flash_swf_url" => '/res/global/plupload/js/plupload.flash.swf',
            "silverlight_xap_url" => '/res/global/plupload/js/plupload.silverlight.xap'
        );

        foreach ($optionDefaults as $name => $value) {
            if (!isset($options[$name])) {
                $options[$name] = $value;
            }
        }
        $optionString = "";
        foreach($options as $key=>$val){
            $optionString .= '"'.$key.'" : ';
            if(is_string($val)) {
                $optionString .= '"'.$val.'",'. PHP_EOL;
            } else {
                $optionString .= $val.',';
            }
        }
        $optionString .= '"url": "'.$url.'"'.PHP_EOL;
        $view->inlineScript()->appendScript(
                "$(function() {" . PHP_EOL .
                '   $("#' . $id . '").plupload({' . PHP_EOL .
                "       " . $optionString . PHP_EOL .
                "});" . PHP_EOL .
                "$('#".$id."Form').submit(function(e) {" . PHP_EOL .
                "var uploader = $('#".$id."').plupload('getUploader');" . PHP_EOL .
                 PHP_EOL .
                "// Files in queue upload them first" . PHP_EOL .
                "if (uploader.files.length > 0) {" . PHP_EOL .
                "    // When all files are uploaded submit form" . PHP_EOL .
                "    uploader.bind('StateChanged', function() {" . PHP_EOL .
                "        if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {" . PHP_EOL .
                "            $('form')[0].submit();" . PHP_EOL .
                "        }" . PHP_EOL .
                "    });" . PHP_EOL .
                "        " . PHP_EOL .
                "    uploader.start();" . PHP_EOL .
                "} else" . PHP_EOL .
                "    alert('You must at least upload one file.');" . PHP_EOL .
                 PHP_EOL .
                "return false;" . PHP_EOL .
            "});" . PHP_EOL .
        "});" . PHP_EOL
        );
        $html  = '<form id="'.$id.'Form">'. PHP_EOL;
        $html .= '<div id="' . $id . '">'. PHP_EOL;
        $html .= '<p>Your Browser dosn\'t support any upload method</p>'. PHP_EOL;
        $html .= '</div>'. PHP_EOL;
        $html .= '</form>'. PHP_EOL;
        return $html;
    }

}

?>
