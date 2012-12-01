<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\FileManager\Entity;

use \Doctrine\ORM\Mapping as ORM;

/**
 * Description of FileSystemObject
 * @ORM\Entity
 * @ORM\Table(name="file_filesystemobject")
 * @author stephan
 */
class FileSystemObject {

    public static $TYPE_FOLDER = "folder";
    public static $TYPE_FILE = "file";

    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $fsoid;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $createUser;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $editUser;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isRootElement;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="object", nullable=true)
     * @var Cloud\FileManager\Entity\Metadata
     */
    protected $metadata;

    /**
     * @ORM\ManyToOne(targetEntity="FileSystemObject", inversedBy="children")
     * @ORM\JoinColumn(name="parent_fso_id", referencedColumnName="fsoid")
     */
    protected $parent;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection Description
     * @ORM\OneToMany(targetEntity="FileSystemObject", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $lastModified;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getType() {
        return $this->type;
    }

    public function getTypeAsString() {
        $ret = "";
        if ($this->type == self::$TYPE_FOLDER)
            $ret = "Ordner";
        return $ret;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getMetadata() {
        return $this->metadata;
    }

    public function setMetadata($metadata) {
        $this->metadata = $metadata;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren() {
        return $this->children;
    }

    public function addChild(FileSystemObject $child) {
        $child->setParent($this);
        $this->children->add($child);
    }

    public function setChildren($children) {
        $this->children = $children;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getCreatedAsString($format = "m.d.Y H:i:s") {
        return $this->created->format($format);
    }

    public function setCreated(\DateTime $created) {
        if ($this->created == null)
            $this->created = $created;
        $this->setLastModified($this->created);
    }

    public function getLastModified() {
        return $this->lastModified;
    }

    public function getLastModifiedAsString($format = "m.d.Y H:i:s") {
        return $this->lastModified->format($format);
    }

    public function setLastModified($lastModified) {
        $this->lastModified = $lastModified;
    }

    public function getFsoid() {
        return $this->fsoid;
    }

    public function hasChildren() {
        return count($this->children) > 0 ? true : false;
    }

    public function isRootElement() {
        return $this->isRootElement;
    }

    public function setRootElement($isRootElement) {
        $this->isRootElement = $isRootElement;
    }

    function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function getCreateUser() {
        return $this->createUser;
    }

    public function setCreateUser($createUser) {
        $this->createUser = $createUser;
    }

    public function getEditUser() {
        return $this->editUser;
    }

    public function setEditUser($editUser) {
        $this->editUser = $editUser;
    }

    
    public function toDynaTreeArray() {
        return array(
            "title" => $this->getName(),
            "isFolder" => true,
            "isLazy" => true,
            "fsoid" => $this->getFsoid()
        );
    }

    public function childsToDynaTreeArray() {
        $ret = array();
        if ($this->hasChildren() == true) {
            foreach ($this->children as $child) {
                if ($child->getType() == self::$TYPE_FOLDER) {
                    $ret[] = array(
                        "title" => $child->getName(),
                        "isFolder" => true,
                        "isLazy" => true,
                        "fsoid" => $child->getFsoid()
                    );
                }
            }
        }
        return $ret;
    }

}

?>
