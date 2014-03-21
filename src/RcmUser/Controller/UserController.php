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
        return array('userService' => $userService);
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/user/foo
        return array();
    }
}
