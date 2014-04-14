<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BjyRoleProvider implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $aclRoleDataMapper = $serviceLocator->get('RcmUser\Acl\AclRoleDataMapper');

        $service = new \RcmUser\Acl\Provider\BjyRoleProvider();
        $service->setAclRoleDataMapper($aclRoleDataMapper);

        return $service;
    }
}