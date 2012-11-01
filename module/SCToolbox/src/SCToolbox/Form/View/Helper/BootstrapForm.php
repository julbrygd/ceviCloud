<?php
namespace SCToolbox\Form\View\Helper;

use ZucchiBootstrap\Form\View\Helper\BootstrapForm as BForm;
use SCToolbox\Form\Element\HTML;
use SCToolbox\Form\Element\Link;
use \Zend\Form\Form;
use \Zend\Form\Fieldset;

class BootstrapForm extends BForm {
	public function __invoke(Form $form, $style = 'vertical')
    { 
        if ($style) {
            $form->setAttribute('class', $form->getAttribute('class') . ' form-' . $style);
        }
        $form->prepare();
        
        $output = '';
        
        $output .= $this->view->form()->openTag($form);
        
        $elements = $form->getIterator();
        foreach ($elements as $key => $element) {
        		if ($element instanceof HTML) {
        				$output .= $element->getHtml();
        		} else if ($element instanceof Link) {
        				$output .= $this->view->scLinkElement($element);
        		} else if ($element instanceof Fieldset) {
                $output .= $this->view->bootstrapCollection($element, $style);
            } else {
                $output .= $this->view->bootstrapRow($element, $style);
            }
        }
        
        $output .= $this->view->form()->closeTag($form);
        
        return $output;
    }
}