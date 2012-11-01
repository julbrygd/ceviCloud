<?php
namespace SCToolbox\Form\Element;

use Zend\Form\Element;

class HTML extends Element {
	private $html;
	
	public function getHtml(){
		return $this->html;
	}
	
	public function setHtml($html){
		$this->html = $html;
		return $this;
	}
}