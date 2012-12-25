<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Client\Entity;

use \Doctrine\ORM\Mapping as ORM;
/**
 * Description of ClientInfo
 *
 * @ORM\Entity
 * @ORM\Table(name="sctoolbox_clientinfo")
 * @author stephan
 */
class ClientInfo {
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $clid;
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $useragent;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $isWebdavClient;
    
    function __construct() {
        
    }
    public function getClid() {
        return $this->clid;
    }

    public function getUseragent() {
        return $this->useragent;
    }

    public function getIsWebdavClient() {
        return $this->isWebdavClient;
    }

    public function setUseragent($useragent) {
        $this->useragent = $useragent;
    }

    public function setIsWebdavClient($isWebdavClient) {
        $this->isWebdavClient = $isWebdavClient;
    }


}

?>
