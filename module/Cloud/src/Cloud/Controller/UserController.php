<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;
use SCToolbox\AAS\Entity\User;

/**
 * Description of UserController
 *
 * @author stephan
 */
class UserController extends AbstractEntityManagerAwareController {

    public function loginAction() {
        $form = new \Cloud\Form\UserLoginForm();
        $viewModel = new \Zend\View\Model\ViewModel();

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $viewModel->data = var_dump($form->getData(), true);
            } else
                $viewModel->form = $form;
        } else
            $viewModel->form = $form;
        return $viewModel;
    }

    public function registerAction() {
        $form = new \Cloud\Form\UserRegisterForm();
        $viewModel = new \Zend\View\Model\ViewModel;
        $viewModel->form = $form;
        $req = $this->getRequest();
        if ($req->isPost()) {
            $form->setData($req->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $pw1 = $data["password1"];
                $pw2 = $data["password2"];
                if ($pw1 != $pw2) {
                    $pel1 = $form->get("password1");
                    $msg = $pel1->getMessages();
                    $msg[] = "Die Passwörter sind nicht gleich";
                    $pel1->setMessages($msg);
                    $pel2 = $form->get("password2");
                    $msg = $pel2->getMessages();
                    $msg[] = "Die Passwörter sind nicht gleich";
                    $pel2->setMessages($msg);
                } else {
                    $user = new User();
                    $user->setPassword($data["password1"]);
                    $user->setActiv(false);
                    $user->setUsername($data["username"]);
                    $user->setEmail($data["email"]);
                    $user->setName($data["name"]);
                    $user->setRegister(new \DateTime());
                    $this->getEntityManager()->persist($user);
                    $this->getEntityManager()->flush();
                    $viewModel = $this->prg("/", true);
                }
            }
        }
        return $viewModel;
    }

    public function testAction() {
        $templatePath = realpath(__DIR__."/../../../view/cloud");
        $renderer = new \Zend\View\Renderer\PhpRenderer();

        $resolver = new \Zend\View\Resolver\AggregateResolver();

        $renderer->setResolver($resolver);

        $map = new \Zend\View\Resolver\TemplateMapResolver(array(
                    'mail/html' => $templatePath . '/user/mail_html.phtml',
                    'mail/text' => $templatePath . '/user/mail_text.phtml',
                ));
        $stack = new \Zend\View\Resolver\TemplatePathStack(array(
                    'script_paths' => array(
                        $templatePath
                    )
                ));

        $resolver->attach($map)    // this will be consulted first
                ->attach($stack);
        $test = $renderer->render("mail/text", array("test"=>"test"));
        
        return new \Zend\View\Model\ViewModel(array(
            "path"=>  realpath(__DIR__."/../../../view/cloud"),
            "test"=>$test
        ));
    }

}

?>
