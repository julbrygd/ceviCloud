<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Upload\Plupload\View\Helper;

use \Zend\View\Helper\AbstractHelper;

/**
 * Description of PluploadHelper
 *
 * @author stephan
 */
class PluploadHelper extends AbstractHelper {
    
    /**
     *
     * @var array
     */
    protected $optionDefaults;
    
    /**
     * @var string
     */
    protected $defaultRuntimes;

    protected function init() {
        $this->optionDefaults = array(
            "max_file_size" => "10mb",
            "chunk_size" => '1mb',
            "unique_names" => true,
            "flash_swf_url" => '/res/global/plupload/js/plupload.flash.swf',
            "silverlight_xap_url" => '/res/global/plupload/js/plupload.silverlight.xap'
        );
        $this->defaultRuntimes = "html5,silverlight,flash,html4";
    }


    public function dialog($url, $id, $dialogOptions, $pluploadOptions = array()){
        $html  = '<div id="'.$id.'Dialog>'.PHP_EOL;
        $html .= $this->getUploadHtml($id).PHP_EOL;
        $html .= '</div>'.PHP_EOL;
        $js = <<< EOF
$("#{$id}Dialog").dialog({
    {$this->arrayToJqueryConfig($dialogOptions)},
    open: function() {
        {$this->getPluploadInitJavaScrtip($id, $this->prepairOptions($pluploadOptions, $url))}
    }
}    
);
{$this->getPluloadFormJavascript($id)}
EOF;
        $this->getView()->inlineScript()->appendScript($js);
        return $html;
    }

    public function __invoke() {

        if($this->optionDefaults == null)
            $this->init ();
        return $this;
    }
    
    protected function prepairOptions($options, $url=""){
        if (!isset($options["runtimes"]))
            $options["runtimes"] = $this->defaultRuntimes;
        

        foreach ($this->optionDefaults as $name => $value) {
            if (!isset($options[$name])) {
                $options[$name] = $value;
            }
        }
        $optionString = $this->arrayToJqueryConfig($options, false);        
        $optionString .= '"url": "'.$url.'"'.PHP_EOL;
        return $optionString;
    }

    protected function arrayToJqueryConfig($array, $removeLastComa=true){
        $optionString = "";
        foreach($array as $key=>$val){
            $optionString .= '"'.$key.'" : ';
            if(is_string($val)) {
                $optionString .= '"'.$val.'",'. PHP_EOL;
            } else if(is_bool($val)) {
                $optionString .= $val ? "true" : "false";
                $optionString .= ",".PHP_EOL;
            } else {
                $optionString .= $val.',';
            }
        }
        if($removeLastComa){
           $optionString = rtrim($optionString, ",");
        }
        return $optionString;
    }

    protected function getPluloadFormJavascript($id){
        $js = <<<EOD
$(function() {
    $("#{$id}Form").submit(function(e) {
        var uploader = $("#{$id}").plupload("getUploader");

        if(uploader.files.length > 0) {
            uploader.bind("StateChanged", function() {
                if(uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $("#{$id}Form").submit();
                }
           };
           uploader.start();
        } else {
            alert("You must at least upload one file");
        }
        return false;
    });
});
EOD;
    }


    protected function getPluploadInitJavaScrtip($id, $optionString){
        $js = <<<EOF
$("#$id").plupload({
    {$optionString}
});
EOF;
        return $js;
    }
    
    protected function getUploadHtml($id){
        $html  = '<form id="'.$id.'Form">'. PHP_EOL;
        $html .= '<div id="' . $id . '">'. PHP_EOL;
        $html .= '<p>Your Browser dosn\'t support any upload method</p>'. PHP_EOL;
        $html .= '</div>'. PHP_EOL;
        $html .= '</form>'. PHP_EOL;
        return $html;
    }

}

?>
