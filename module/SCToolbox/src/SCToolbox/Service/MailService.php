<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;
use SCToolbox\Configuration;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Transport\SmtpOptions;

/**
 * Description of MailService
 *
 * @author stephan
 */
class MailService implements ServiceLocatorAwareInterface {

    /**
     *
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $sl;

    /**
     *
     * @var SCToolbox\Configuration
     */
    protected $config;

    /**
     *
     * @var Zend\Mail\Transport\TransportInterface
     */
    protected $transport;

    function __construct() {
        $this->config = null;
        $this->transport = null;
    }

    protected function init() {
        $this->config = $this->getServiceLocator()->get("SCToolbox/Config");
        $mail = $this->config->getMail();
        if ($mail["transport"] == "smtp") {
            $this->transport = new SmtpTransport();
            $options = new SmtpOptions($mail["options"]);
            $this->transport->setOptions($options);
        }
    }

    public function send(Message $mail) {
        if($this->transport==null){
            $this->init();
        }
        $this->transport->send($mail);
    }

    /**
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator() {
        return $this->sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->sl = $serviceLocator;
    }

}

?>
