<?php

namespace DoctrineORMModule\Proxy\__CG__\Cloud\FileManager\Entity;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class FileSystemObject extends \Cloud\FileManager\Entity\FileSystemObject implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function getName()
    {
        $this->__load();
        return parent::getName();
    }

    public function setName($name)
    {
        $this->__load();
        return parent::setName($name);
    }

    public function getType()
    {
        $this->__load();
        return parent::getType();
    }

    public function getTypeAsString()
    {
        $this->__load();
        return parent::getTypeAsString();
    }

    public function setType($type)
    {
        $this->__load();
        return parent::setType($type);
    }

    public function getMetadata()
    {
        $this->__load();
        return parent::getMetadata();
    }

    public function hasMetadata()
    {
        $this->__load();
        return parent::hasMetadata();
    }

    public function setMetadata(\Cloud\FileManager\Entity\Metadata $metadata)
    {
        $this->__load();
        return parent::setMetadata($metadata);
    }

    public function setMetadataValue($name, $value)
    {
        $this->__load();
        return parent::setMetadataValue($name, $value);
    }

    public function getParent()
    {
        $this->__load();
        return parent::getParent();
    }

    public function setParent(\Cloud\FileManager\Entity\FileSystemObject $parent)
    {
        $this->__load();
        return parent::setParent($parent);
    }

    public function getChildren()
    {
        $this->__load();
        return parent::getChildren();
    }

    public function addChild(\Cloud\FileManager\Entity\FileSystemObject $child)
    {
        $this->__load();
        return parent::addChild($child);
    }

    public function setChildren($children)
    {
        $this->__load();
        return parent::setChildren($children);
    }

    public function getCreated()
    {
        $this->__load();
        return parent::getCreated();
    }

    public function getCreatedAsString($format = 'm.d.Y H:i:s')
    {
        $this->__load();
        return parent::getCreatedAsString($format);
    }

    public function setCreated(\DateTime $created)
    {
        $this->__load();
        return parent::setCreated($created);
    }

    public function getLastModified()
    {
        $this->__load();
        return parent::getLastModified();
    }

    public function getLastModifiedAsString($format = 'm.d.Y H:i:s')
    {
        $this->__load();
        return parent::getLastModifiedAsString($format);
    }

    public function setLastModified($lastModified)
    {
        $this->__load();
        return parent::setLastModified($lastModified);
    }

    public function getFsoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["fsoid"];
        }
        $this->__load();
        return parent::getFsoid();
    }

    public function hasChildren()
    {
        $this->__load();
        return parent::hasChildren();
    }

    public function isRootElement()
    {
        $this->__load();
        return parent::isRootElement();
    }

    public function isFolder()
    {
        $this->__load();
        return parent::isFolder();
    }

    public function isFile()
    {
        $this->__load();
        return parent::isFile();
    }

    public function getPath($withStartingSlash = true)
    {
        $this->__load();
        return parent::getPath($withStartingSlash);
    }

    public function getPath2($path = NULL)
    {
        $this->__load();
        return parent::getPath2($path);
    }

    public function setRootElement($isRootElement)
    {
        $this->__load();
        return parent::setRootElement($isRootElement);
    }

    public function getCreateUser()
    {
        $this->__load();
        return parent::getCreateUser();
    }

    public function setCreateUser($createUser)
    {
        $this->__load();
        return parent::setCreateUser($createUser);
    }

    public function getEditUser()
    {
        $this->__load();
        return parent::getEditUser();
    }

    public function setEditUser($editUser)
    {
        $this->__load();
        return parent::setEditUser($editUser);
    }

    public function toDynaTreeArray()
    {
        $this->__load();
        return parent::toDynaTreeArray();
    }

    public function childsToDynaTreeArray()
    {
        $this->__load();
        return parent::childsToDynaTreeArray();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'fsoid', 'name', 'createUser', 'editUser', 'isRootElement', 'type', 'created', 'lastModified', 'metadata', 'parent', 'children');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}