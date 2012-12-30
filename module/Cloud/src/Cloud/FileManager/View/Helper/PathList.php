<?php

namespace Cloud\FileManager\View\Helper;

use Cloud\FileManager\Path\Path;

/**
 * Description of PathList
 *
 * @author stephan
 */
class PathList  extends \Zend\View\Helper\AbstractHelper{
    
    public function __invoke() {
        return $this;
    }

    public function show(Path $path) {
        $ret = "";
        $view = $this->getView();
        $rootLink = '<a href="'.$view->url("cloud/default", array("controller"=>"file")).'">/</a>&nbsp;';
        $ret = $rootLink;
        $currentPath = "";
        $url = $view->url('cloud/showPaht');
        foreach($path->getElement() as $index=>$element){
            $tmp = '<a id="fsorow_'.$element->id.'" class="fsFolderLink" href="';
            $name = $element->name;
            $currentPath .= "/".$name;
            $currentPath = trim($currentPath, "/");
            $tmp .= $url . $currentPath .'">';
            $tmp .= $name;
            $tmp .= "</a>";
            if($ret == $rootLink) {
                $ret .= $tmp."&nbsp;";;
            } else {
                $ret .= "/&nbsp;".$tmp."&nbsp;";
            }
        }
        return $ret;
    }
}

?>
