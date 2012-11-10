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
    public static $TYPE_FOLDER="folder";
    public static $TYPE_FILE="file";
    
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

    public function getChildren() {
        return $this->children;
    }

    public function setChildren($children) {
        $this->children = $children;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated(\DateTime $created) {
        if($this->created == null)
            $this->created = $created;
        $this->setLastModified($this->created);
    }

    public function getLastModified() {
        return $this->lastModified;
    }

    public function setLastModified($lastModified) {
        $this->lastModified = $lastModified;
    }

    public function getFsoid() {
        return $this->fsoid;
    }

    function __construct() {
        $this->children =  new \Doctrine\Common\Collections\ArrayCollection();
    }

}

?>
