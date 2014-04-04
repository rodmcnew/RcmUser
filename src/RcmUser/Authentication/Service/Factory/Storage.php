<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Authentication\Service\Factory;

use RcmUser\Authentication\Storage\UserSession;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Storage implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        return new UserSession();
    }
}