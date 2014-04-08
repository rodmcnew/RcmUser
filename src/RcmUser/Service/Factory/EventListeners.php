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


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventListeners implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $listeners = array();

        try {
            $eventListeners = $serviceLocator->get('RcmUser\User\EventListeners');
            $listeners = $eventListeners;
        } catch (\Exception $e) {
            // no listeners
        }

        try {
            $eventListeners = $serviceLocator->get('RcmUser\Authentication\EventListeners');
            $listeners = array_merge($eventListeners, $listeners);
        } catch (\Exception $e) {
            // no listeners
        }

        try {
            $eventListeners = $serviceLocator->get('RcmUser\Acl\EventListeners');
            $listeners = array_merge($eventListeners, $listeners);
        } catch (\Exception $e) {
            // no listeners
        }

        return $listeners;
    }
}