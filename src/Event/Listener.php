<?php

namespace RcmUser\Event;

use Zend\EventManager\Event;

/**
 * Class Listener
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
interface Listener
{
    /**
     * __invoke
     *
     * @param Event $event
     *
     * @return bool true to stop event propagation
     */
    public function __invoke(Event $event);
}
