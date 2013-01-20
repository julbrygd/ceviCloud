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
     * @var DoctrineModule\Options\Authentication;
     */
    protected $options;

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, \Zend\ServiceManager\ServiceLocatorInterface $sl) {
        $this->em = $em;
        $this->auth = new AuthenticationService();
        $this->options = new Authentication();
        $conf = $sl->get("SCToolbox/Config");
        $class = $conf->getAAS("class");
        $pwProp = $conf->getAAS("passwordProperty");
        $userProp = $conf->getAAS("userProperty");
        if(!class_exists($class)){
            $class = "SCToolbox\AAS\Entity\User";
        }
        $this->options->setObjectRepository($this->em->getRepository($class));
        $this->options->setCredentialProperty($pwProp)->setIdentityProperty($userProp);
        $this->options->setCredentialCallable(function(\SCToolbox\AAS\Entity\UserInterface $user, $passwordGiven) {
                    return $user->checkPassword($passwordGiven);
                });
        $adapter = new ObjectRepository($this->options);
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
    
    public function authDigest($user, $realm, $hash){
        $org = $this->options->getCredentialCallable();
        $this->options->setCredentialCallable(function(\SCToolbox\AAS\Entity\UserInterface $user, $passwordGiven) {
                    $ret = false;
                    if(method_exists($user, "getDigest")) {
                        $digest = $user->getDigest();
                        $ret = ($digest == $passwordGiven);
                    }
                    return $ret;
                });
        $this->auth->getAdapter()->setOptions($this->options);
        $this->auth->getAdapter()->setIdentityValue($user);
        $this->auth->getAdapter()->setCredentialValue($hash);
        $ret = $this->auth->authenticate();
        $this->options->setCredentialCallable($org);
        $this->auth->getAdapter()->setOptions($this->options);
        return $ret;
        
    }
    
    public function getUser(){
        return $this->auth->getIdentity();
    }

    public function __call($name, $arguments) {
        if (method_exists($this->auth, $name)) {
            call_user_func_array(array($this->auth,$name), $arguments);
        } else if (method_exists($this->auth->getAdapter(), $name))
            call_user_func_array(array($this->auth->getAdapter(),$name), $arguments);
        else if (method_exists($this->auth->getIdentity(), $name))
            call_user_func_array(array($this->auth->getIdentity(), $name), $arguments);
        else if (method_exists($this->auth->getStorage(), $name))
            call_user_func_array(array($this->auth->getStorage(),$name), $arguments);
    }

}

?>
