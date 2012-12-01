<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager\Doctrine;

use \Doctrine\ORM\Event\OnFlushEventArgs;
use \Doctrine\ORM\UnitOfWork;
use Cloud\FileManager\Entity\FileSystemObject;

/**
 * Description of OnFlushListener
 *
 * @author stephan
 */
class OnFlushListener {

    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $_sm;

    function __construct($sm = null) {
        $this->_sm = $sm;
    }

    public function onFlush(OnFlushEventArgs $eventArgs) {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $meta = $em->getClassMetadata("\Cloud\FileManager\Entity\FileSystemObject");
        $now = new \DateTime();
        foreach ($uow->getScheduledEntityInsertions() AS $entity) {
            if ($entity instanceof FileSystemObject) {
                if ($entity->getCreated() == null) {
                    $entity->setCreated($now);
                }
                $entity->setEditUser($this->getUser());
                $entity->setCreateUser($this->getUser());
                $uow->recomputeSingleEntityChangeSet($meta, $entity);
            }
        }

        foreach ($uow->getScheduledEntityUpdates() AS $entity) {
            if ($entity instanceof FileSystemObject) {
                $entity->setLastModified($now);
                $entity->setEditUser($this->getUser());
                $uow->recomputeSingleEntityChangeSet($meta, $entity);
            }
        }
    }

    private function getUser() {
        $username = "";
        if ($this->_sm != null) {
            $auth = $this->_sm->get("SCToolbox\AAS\AuthService");
            $username = $auth->getUser()->getName();
        }
        return $username;
    }

}

?>
