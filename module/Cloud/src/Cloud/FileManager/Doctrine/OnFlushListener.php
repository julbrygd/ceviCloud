<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cloud\FileManager\Doctrine;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Cloud\FileManager\Entity\FileSystemObject;
/**
 * Description of OnFlushListener
 *
 * @author stephan
 */
class OnFlushListener {
     public function onFlush(OnFlushEventArgsshEventArgs $eventArgs){
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $now = new \DateTime();
        foreach ($uow->getScheduledEntityInsertions() AS $entity) {
            if($entity instanceof FileSystemObject){
                if($entity->getCreated()==null)
                    $entity->setCreated($now);
            }
        }

        foreach ($uow->getScheduledEntityUpdates() AS $entity) {
            if($entity instanceof FileSystemObject){
                $entity->setLastModified($now);
            }
        }
     }
}

?>
