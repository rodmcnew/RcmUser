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

use RcmUser\User\Event\CreateUserPreListener;
use RcmUser\User\Event\UpdateUserPreListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventListeners implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $listeners = array();
        // User
        $createUserPreListener = new CreateUserPreListener();
        $listeners[] = $createUserPreListener;

        $updateUserPreListener = new UpdateUserPreListener();
        $listeners[] = $updateUserPreListener;

        return $listeners;
    }
}
