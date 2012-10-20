<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cloud\Entity;
/**
 * Description of AnnotationDriver
 *
 * @author stephan
 */
class AnnotationDriver  extends \Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver{
    public function loadMetadataForClass($className, \Doctrine\Common\Persistence\Mapping\ClassMetadata $metadata) {
        
    }
}

?>
