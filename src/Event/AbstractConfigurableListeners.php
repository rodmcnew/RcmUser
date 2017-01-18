<?php

namespace RcmUser\Event;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Class AbstractConfigurableListeners
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
abstract class AbstractConfigurableListeners implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $listenerConfig
        = [
            /* EXAMPLE *
            'name' => [
                'id' => AclDataService::class,
                'event' => AclDataService::EVENT_CREATE_ACL_ROLE,
                // callable
                'callback' => Listener::class,
                'priority' => -1,
            ]
            /* */
        ];

    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * Constructor.
     *
     * @param array $listenerConfig
     */
    public function __construct(
        array $listenerConfig
    ) {
        $this->listenerConfig = $listenerConfig;
    }

    /**
     * attach
     *
     * @param UserEventManager|EventManagerInterface $userEventManager events
     *
     * @return void
     */
    public function attach(EventManagerInterface $userEventManager)
    {
        $sharedEvents = $userEventManager->getSharedManager();

        foreach ($this->listenerConfig as $name => $eventData) {
            $this->listeners[$name] = $sharedEvents->attach(
                $eventData['id'],
                $eventData['event'],
                $eventData['callback'],
                $eventData['priority']
            );
        }
    }

    /**
     * detach
     *
     * @param EventManagerInterface $userEventManager events
     *
     * @return void
     */
    public function detach(EventManagerInterface $userEventManager)
    {
        foreach ($this->listeners as $name => $listener) {
            if ($userEventManager->detach($listener)) {
                unset($this->listeners[$name]);
            }
        }
    }
}
