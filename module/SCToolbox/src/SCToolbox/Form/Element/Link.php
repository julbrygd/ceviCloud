<?php
namespace SCToolbox\Form\Element;

use Zend\Form\Element;

class Link extends Element {
	protected $route;
	protected $url;
	protected $label;
	
	public function getUrlRoute(){
		return $this->route;
	}
	
	public function setUrlRoute($route){
		$this->route = $route;
		return $this;
	}
	
	public function getHref(){
		return $this->url;
	}
	
	public function setHref($url){
		$this->url = $url;
		return $this;
	}
	
	public function getText(){
		return $this->label;
	}
	
	public function setText($label){
		$this->label = $label;
		return $this;
	}
}