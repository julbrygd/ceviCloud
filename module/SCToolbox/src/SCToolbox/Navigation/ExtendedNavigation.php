<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Navigation;

use Zend\Navigation\Navigation as ZendNavigation;
use Zend\Navigation\Exception\InvalidArgumentException;
use Zend\Navigation\Page\AbstractPage;

/**
 * Description of ExtendedNavigation
 *
 * @author stephan
 */
class ExtendedNavigation extends ZendNavigation {

    protected static $DEFAULT_ROUTER;
    protected static $DEFAULT_ROUTER_MATCH;

    /**
     *
     * @var String
     */
    protected $menuName;

    public function getMenuName() {
        return $this->menuName;
    }

    public function setMenuName($name) {
        $this->name = menuName;
    }

    function __construct($menuName, $pages = null) {
        $this->menuName = $menuName;
        parent::__construct($pages);
    }

    public function addPage($page) {
        if (!$page instanceof AbstractPage) {
            if (!is_array($page) && !$page instanceof Traversable) {
                throw new InvalidArgumentException(
                        'Invalid argument: $page must be an instance of '
                        . 'Zend\Navigation\Page\AbstractPage or Traversable, or an array'
                );
            }
            /**
             * @var \Zend\Navigation\Page\AbstractPage
             */
            unset($page["router"]);
            unset($page["route_match"]);
            $page = \Zend\Navigation\Page\AbstractPage::factory($page);
            if ($page->getId() == null) {
                $page->setId($this->getMenuName() . "_" . $page->getLabel());
            }
            if ($page instanceof \Zend\Navigation\Page\Mvc) {
                if (self::getDefaultRouter() != null && $page->getRouter() == null) {
                    $page->setRouter(self::getDefaultRouter());
                    if (self::getDefaultRouterMatch() != null)
                        $page->setRouteMatch(self::getDefaultRouterMatch());
                }
            }
            $page->setActive($page->isActive());
        }
        return parent::addPage($page);
    }

    public static function setDefaultRouter($router) {
        self::$DEFAULT_ROUTER = $router;
    }

    public static function getDefaultRouter() {
        return self::$DEFAULT_ROUTER;
    }

    public static function setDefaultRouterMatch($routerMatch) {
        self::$DEFAULT_ROUTER_MATCH = $routerMatch;
    }

    public static function getDefaultRouterMatch() {
        return self::$DEFAULT_ROUTER_MATCH;
    }

}

?>
