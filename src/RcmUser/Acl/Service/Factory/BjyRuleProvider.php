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

class BjyRuleProvider implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $aclRuleDataMapper = $serviceLocator->get('RcmUser\Acl\AclRuleDataMapper');

        $service = new \RcmUser\Acl\Provider\BjyRuleProvider();
        $service->setRuleDataMapper($aclRuleDataMapper);
        return $service;
    }
}