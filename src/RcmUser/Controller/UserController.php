<?php
/**
 *
 */

namespace RcmUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $test = array(
            'userController' => $this,
            'rcmUserService' => $this->getServiceLocator()->get('RcmUser\Service\RcmUserService'),
            'bjyAuthService' => $this->getServiceLocator()->get('BjyAuthorize\Service\Authorize'),
        );

        return $test;
    }
}
