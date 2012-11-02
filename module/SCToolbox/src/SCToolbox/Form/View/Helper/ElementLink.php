<?php


namespace SCToolbox\Form\View\Helper;

use \Zend\View\Helper\AbstractHelper;
use \Zend\Form\Form;
use \SCToolbox\Form\Element\Link;
use \Zend\Form\Fieldset;


class ElementLink extends AbstractHelper{
	public function __invoke(Link $element){
		$output = '<a href="';
		$url = $element->getHref();
		if($url==null || strtolower($url)=="route"){
			$route = $element->getUrlRoute();
			$url = $this->view->url($route);
		}
		$output .= $url.'"';
		foreach($element->getAttributes() as $key=>$val){
			if($key=="name") continue;
			$output .= " ".$key.'="'.$val.'"';
		}
		$output .='>'.$element->getText()."</a>";
		return $output;
	}
}