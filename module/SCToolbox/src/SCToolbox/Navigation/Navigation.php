<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Navigation;

use SCToolbox\Doctrine\EntityManagerAwareInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * Description of Navigation
 *
 * @author const
 */
class Navigation implements EntityManagerAwareInterface, ServiceManagerAwareInterface {

    /**
     * @var array
     */
    protected $_menus = array();

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $_sm;

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->_em;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $em) {
        $this->_em = $em;
    }

    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
        $this->_sm = $serviceManager;
    }

    /**
     * 
     * @param string Menuname
     * @return \Zend\Navigation\Navigation
     */
    public function getMenu($name) {
        if(ExtendedNavigation::getDefaultRouter()==null){
            ExtendedNavigation::setDefaultRouter($this->_sm->get("Router"));
            \Zend\Navigation\Page\Mvc::setDefaultRouter(ExtendedNavigation::getDefaultRouter());
            ExtendedNavigation::setDefaultRouterMatch($this->_sm->get("Router")->match($this->_sm->get("Request")));
        }
        if (!isset($this->_menus[$name]))
            $this->_menus[$name] = $this->loadMenu($name);
        if($this->_menus[$name] instanceof Entity\Menu)
            $this->_menus[$name] = $this->_menus[$name];
        return $this->_menus[$name];
    }
    
    public function saveMenu(ExtendedNavigation $menu){
        return $this->save($menu->getMenuName(), $menu);
    }

    public function save($name, \Zend\Navigation\AbstractContainer $menu) {
        $repo = $this->getEntityManager()->getRepository('SCToolbox\Navigation\Entity\Menu');
        $found = $repo->findBy(array("name" => $name));
        if(count($found)==0){
            $found = new Entity\Menu();
            $found->setName($name);
        }else{
            $found = $found[0];
        }
        $found->setPages($menu->toArray());
        $this->getEntityManager()->persist($found);
        $this->getEntityManager()->flush();
        return $this;
    }
    
    /**
     * 
     * @param \Zend\Navigation\AbstractContainer $menu
     * @return type
     */
    protected function loadMenu($name) {
        $ret = null;
        $repo = $this->getEntityManager()->getRepository('SCToolbox\Navigation\Entity\Menu');
        $found = $repo->findBy(array("name" => $name));
        $anz = count($found);
        if ($anz == 0) {
            $ret = new ExtendedNavigation($name);
        } else if ($anz == 1) {
            $ret = new ExtendedNavigation($name,$found[0]->getPages());
        }
        return $ret;
    }
}

?>
