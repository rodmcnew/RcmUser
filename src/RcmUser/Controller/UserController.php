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
        $userService = $this->getServiceLocator()->get('RcmUser\Service\RcmUserService');
        $bjyAuthService = $this->getServiceLocator()->get('BjyAuthorize\Service\Authorize');
        return array('userService' => $userService, 'bjyAuthService' => $bjyAuthService);
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/user/foo
        return array();
    }
}
