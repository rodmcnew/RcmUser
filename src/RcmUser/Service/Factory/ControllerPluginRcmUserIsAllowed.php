<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Service\Factory;

use RcmUser\Controller\Plugin\RcmUserIsAllowed;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerPluginRcmUserIsAllowed implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $mgr)
    {
        $serviceLocator = $mgr->getServiceLocator();

        $userAuthorizeService = $serviceLocator->get('RcmUser\Acl\Service\UserAuthorizeService');

        $service = new RcmUserIsAllowed($userAuthorizeService);

        return $service;
    }
}