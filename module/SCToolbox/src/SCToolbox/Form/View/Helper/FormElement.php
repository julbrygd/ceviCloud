<?php


namespace SCToolbox\Form\View\Helper;

use \Zend\Form\Form;
use \SCToolbox\Form\Element\Link;
use \Zend\Form\Fieldset;
use \Zend\Form\View\Helper\FormElement as ZendFormElement;
use \Zend\Form\Element;
use \Zend\Form\ElementInterface;


class FormElement extends ZendFormElement{
/**
     * Render an element
     *
     * Introspects the element type and attributes to determine which
     * helper to utilize when rendering.
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }
        if($element instanceof Link){
        	$helper=$renderer->plugin("scLinkElement");
        	return $helper($element);
        }
        return parent::render($element);
		}
}