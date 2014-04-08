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

use RcmUser\User\Event\CreateUserPreDataPrepListener;
use RcmUser\User\Event\CreateUserPreListener;
use RcmUser\User\Event\CreateUserPreValidatorListener;
use RcmUser\User\Event\UpdateUserPreDataPrepListener;
use RcmUser\User\Event\UpdateUserPreListener;
use RcmUser\User\Event\UpdateUserPrePrepListener;
use RcmUser\User\Event\UpdateUserPreValidatorListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventListeners implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $listeners = array();
        // User
        $listeners[] = new CreateUserPreDataPrepListener();
        $listeners[] = new UpdateUserPreDataPrepListener();
        $listeners[] = new CreateUserPreValidatorListener();
        $listeners[] = new UpdateUserPreValidatorListener();

        return $listeners;
    }
}
