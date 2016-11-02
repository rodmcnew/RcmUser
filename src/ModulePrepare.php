<?php

namespace RcmUser;

use Interop\Container\ContainerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Class ModulePrepare
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ModulePrepare
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return EventManager
     */
    public function __invoke($container)
    {
        $eventManager = $container->get('RcmUser\Event\UserEventManager');

        $listeners = $container->get('RcmUser\Event\Listeners');

        /** @var ListenerAggregateInterface $listener */
        foreach ($listeners as $listener) {
            $listener->detach($eventManager);
            $listener->attach($eventManager);
        }

        return $eventManager;
    }
}
