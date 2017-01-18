<?php

namespace RcmUser\Log\Event;

use RcmUser\Log\Logger;
use Zend\EventManager\Event;

class LoggerListenerOnAuthenticateFail extends AbstractLoggerListener implements LoggerListener
{
    /**
     * __invoke
     *
     * @param Event $event
     *
     * @return void
     */
    public function __invoke(Event $event)
    {
        // TODO: Implement __invoke() method.
    }
}
