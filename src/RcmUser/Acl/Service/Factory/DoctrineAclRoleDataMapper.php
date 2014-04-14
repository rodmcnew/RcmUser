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

class DoctrineAclRoleDataMapper implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $service = new \RcmUser\Acl\Db\DoctrineAclRoleDataMapper();
        $service->setEntityManager($em);
        $service->setEntityClass('RcmUser\Acl\Entity\DoctrineAclRole');

        return $service;
    }
}