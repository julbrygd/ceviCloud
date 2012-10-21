<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;

/**
 * Description of UserController
 *
 * @author stephan
 */
class UserController extends AbstractEntityManagerAwareController {

    public function loginAction() {
        $form = new \Cloud\Form\UserLoginForm();
        $viewModel = new \Zend\View\Model\ViewModel();
        $viewModel->form = $form;
        if($this->getRequest()->isPost()){
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()){
                $viewModel->data = var_dump($form->getData(), true);
            }
        }
        return $viewModel;
    }

}

?>
