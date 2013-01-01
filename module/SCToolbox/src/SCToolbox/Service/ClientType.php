<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Service;

use SCToolbox\Doctrine\EntityManagerAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Doctrine\ORM\EntityManager;
use \Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ClientType
 *
 * @author stephan
 */
class ClientType implements EntityManagerAwareInterface, ServiceLocatorAwareInterface {

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $_sl;

    /**
     *
     * @var \Zend\Http\Request
     */
    protected $request;
    protected $browserInfos;

    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repo;

    function __construct() {
        $this->_em = null;
        $this->_sl = null;
    }

    public function init() {
        if ($this->_sl != null && $this->_em != null) {
            $this->request = $this->_sl->get("Request");
            if ($this->request instanceof \Zend\Http\Request) {
                $this->repo = $this->_em->getRepository("SCToolbox\Client\Entity\ClientInfo");
                $method = $this->request->getMethod();
                $agent = $this->request->getHeader("useragent")->getFieldValue();
                $this->browserInfos = get_browser($agent);
                $ret = $this->repo->findOneBy(array("useragent" => $agent));
                if ($ret == null) {
                    $ret = new \SCToolbox\Client\Entity\ClientInfo();
                    $ret->setUseragent($agent);
                    if ($method == "PROPFIND") {
                        $ret->setIsWebdavClient(true);
                    } else {
                        $ret->setIsWebdavClient(false);
                    }
                    $this->_em->persist($ret);
                    $this->_em->flush();
                }
                $this->browserInfos->webdav = $ret->getIsWebdavClient();
            }
        }
    }

    public function getBrowserInfo() {
        return $this->browserInfos;
    }

    public function isWebDav() {
        return $this->browserInfos->webdav;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->_em;
    }

    public function setEntityManager(EntityManager $em) {
        $this->_em = $em;
    }

    /**
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator() {
        return $this->_sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
    }

}

?>
