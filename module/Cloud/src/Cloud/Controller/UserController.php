<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;
use SCToolbox\AAS\Entity\User;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

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
                    $this->sendMail($user);
                    $viewModel = $this->prg("/", true);
                }
            }
        }
        return $viewModel;
    }

    public function testAction() {
        $q = $this->getEntityManager()->createQuery("SELECT u From SCToolbox\AAS\Entity\User u WHERE u.username = :name");
        $q->setParameter("name", "stephan");
        return array("path" => $this->sendMail($q->getSingleResult()));
    }

    private function getMail($data) {
        $templatePath = realpath(__DIR__ . "/../../../view/cloud");
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
        return array(
            "text" => $renderer->render("mail/text", $data),
            "html" => $renderer->render("mail/html", $data)
        );
    }

    private function sendMail($user) {
        $uri = $this->getRequest()->getUri();
        $url = $uri->getScheme() . "://" . $uri->getHost() . $this->getRequest()->getBaseUrl();
        $username = $user->getUsername();
        $key = md5($user->getRegister()->getTimestamp());
        $url .= $this->url()->fromRoute("cloud/userActivate", array("username" => $username, "key" => $key));

        $data = array(
            "username" => $user->getUsername(),
            "url" => $url,
            "name" => $user->getName(),
        );

        $text = $this->getMail($data);
        $mm = new MimeMessage();
        $tPart = new MimePart($text["text"]);
        $tPart->type = "text/plain";

        $hPart = new MimePart($text["html"]);
        $hPart->type = "text/html";
        $mm->addPart($tPart);
        $mm->addPart($hPart);
        $msg = new Message();
        $msg->setEncoding("UTF-8")->setBody($mm);
        $msg->addFrom("stephan.conrad@gmail.com")->setTo("stephan.conrad@gmail.com");
        $msg->setSubject("Cevi Birsfelden User Aktivierung");
        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
                    'name' => 'asmtp.mail.hostpoint.ch',
                    'host' => 'asmtp.mail.hostpoint.ch',
                    'connection_class' => 'login',
                    'connection_config' => array(
                        'username' => 'stephan.conrad@cevi-birsfelden.ch',
                        'password' => 'ascha33',
                    ),
                ));
        $transport->setOptions($options);

        $transport->send($msg);

        return array("path" => $mm);
    }

    public function activateAction() {
        $viewModel = new \Zend\View\Model\ViewModel();
        $router = $this->getEvent()->getRouteMatch();
        if ($router->getMatchedRouteName() == "cloud/userActivate") {
            $key = $router->getParam("key");
            $username = $router->getParam("username");
            if ($key == null || $username == null) {
                $viewModel = $this->redirect()->toRoute("home");
                return $viewModel;
            } else {
                $viewModel->url = $this->url()->fromRoute("home");
                $q = $this->getEntityManager()->createQuery("SELECT u From SCToolbox\AAS\Entity\User u WHERE u.username = :name");
                $q->setParameter("name", $username);
                try {
                    $tmp = $q->getSingleResult();
                    $viewModel->failer = false;
                    $check = md5($tmp->getRegister()->getTimestamp());
                    if ($check == $key) {
                        //9db9ff1953780c564e34a64f38e669c0
                        $tmp->setActiv(true);
                        $this->getEntityManager()->flush();
                        $viewModel->failer = false;
                    } else {
                        $viewModel->failer = true;
                    }
                } catch (\Exception $e) {
                    $viewModel->failer = true;
                }
            }
        }
        return $viewModel;
    }

}

?>
