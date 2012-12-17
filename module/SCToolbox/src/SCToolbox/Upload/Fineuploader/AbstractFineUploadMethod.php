<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Upload\Fineuploader;
/**
 * Description of AbstractFineUploadMethod
 *
 * @author stephan
 */
abstract class AbstractFineUploadMethod {
    abstract public function getName();
    abstract public function getSize();
    abstract public function save($path);
    abstract public function getParameter($name);
}

?>
