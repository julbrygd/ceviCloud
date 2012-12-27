<?php
namespace Cloud\FileManager\WebDav;

use Sabre\DAV\Auth\Backend\AbstractDigest;
use Cloud\AAS\Entity\DigestUser;
use Doctrine\ORM\EntityManager;
use SCToolbox\AAS\AuthService;


/**
 * Description of DigestAuth
 *
 * @author stephan
 */
class DigestAuth extends AbstractDigest{
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    
    /**
     *
     * @var SCToolbox\AAS\AuthService
     */
    protected $auth;


    /**
     *
     * @var Cloud\AAS\Entity\DigestUser
     */
    protected $user;


    public function __construct(EntityManager $em, AuthService $auth) {
        $this->em = $em;
        $this->auth = $auth;
    }

    public function getDigestHash($realm, $username) {
        return $this->getUser($username)->getDigest();
    }
    
    /**
     * 
     * @param string $name
     * @return Cloud\AAS\Entity\DigestUser
     */
    private function getUser($name){
        if($this->user == null){
            $this->user = $this->em->getRepository("Cloud\AAS\Entity\DigestUser")->findOneBy(array("username"=>$name));
        }
        return $this->user;
    }
    
    public function authenticate(\Sabre\DAV\Server $server, $realm) {
        $ret =  parent::authenticate($server, $realm);
        
        $this->auth->authDigest($this->getCurrentUser(), $realm, $this->getDigestHash($realm, $this->getCurrentUser()));
        return $ret;
    }

}

?>
