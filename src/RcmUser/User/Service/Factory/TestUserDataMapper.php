<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TestUserDataMapper implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed|\RcmUser\User\Db\DoctrineUserDataMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $dm = new \RcmUser\User\Db\TestUserDataMapper();

        return $dm;
    }
}