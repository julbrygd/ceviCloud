<?php

namespace Cloud\Controller;

use SCToolbox\Mvc\Controller\AbstractEntityManagerAwareController;
use \Zend\View\Model\ViewModel;
use SCToolbox\Client\Entity\ClientInfo;
use Zend\View\Model\JsonModel;

/**
 * Description of SettingsController
 *
 * @author stephan
 */
class SettingsController extends AbstractEntityManagerAwareController {

    public function davAction() {
        $repo = $this->getEntityManager()->getRepository("SCToolbox\Client\Entity\ClientInfo");
        $ret = null;
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            foreach ($data as $id => $val) {
                $o = $repo->find($id);
                $o->setIsWebdavClient($val == 'true');
                $this->getEntityManager()->persist($o);
            }
            $this->getEntityManager()->flush();
            $ret = new JsonModel(array("status" => "ok"));
        } else {
            $infos = $repo->findAll();
            $ret = new ViewModel(array("clients" => $infos));
        }
        return $ret;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->res()->addJs("js/settings.js");
        return parent::onDispatch($e);
    }

}

?>
