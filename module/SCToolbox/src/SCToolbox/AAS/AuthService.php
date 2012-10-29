<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\AAS;

use Zend\Authentication\AuthenticationService;
use DoctrineModule\Options\Authentication;
use DoctrineModule\Authentication\Adapter\ObjectRepository;

/**
 * Description of AuthService
 *
 * @author stephan
 */
class AuthService {
    public static $DEFAULT_LOGIN_ROOTER = "SCToolbox/AAS/AuthNeeded";

    /**
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $auth;

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        $this->auth = new AuthenticationService();
        $options = new Authentication();
        $options->setObjectRepository($this->em->getRepository("SCToolbox\AAS\Entity\User"));
        $options->setCredentialProperty("password")->setIdentityProperty("username");
        $options->setCredentialCallable(function(\SCToolbox\AAS\Entity\User $user, $passwordGiven) {
                    return $user->checkPassword($passwordGiven);
                });
        $adapter = new ObjectRepository($options);
        $this->auth->setAdapter($adapter);
        
        \SCToolbox\AAS\View\Helper\UserHelper::SET_AUTH_SERVICE($this);
    }

    public function isLoggedin() {
        return $this->auth->hasIdentity();
    }

    /**
     * 
     * @param String $user
     * @param String $password
     * @return \Zend\Authentication\Result
     */
    public function login($user, $password) {
        $this->auth->getAdapter()->setIdentityValue($user);
        $this->auth->getAdapter()->setCredentialValue($password);
        return $this->auth->authenticate();
    }
    
    public function getUser(){
        return $this->auth->getIdentity();
    }

    public function __call($name, $arguments) {
        if (method_exists($this->auth, $name))
            call_user_func_array(array($this->auth,$name), $arguments);
        else if (method_exists($this->auth->getAdapter(), $name))
            call_user_func_array(array($this->auth->getAdapter(),$name), $arguments);
        else if (method_exists($this->auth->getIdentity(), $name))
            call_user_func_array(array($this->auth->getIdentity(), $name), $arguments);
        else if (method_exists($this->auth->getStorage(), $name))
            call_user_func_array(array($this->auth->getStorage(),$name), $arguments);
    }

}

?>
