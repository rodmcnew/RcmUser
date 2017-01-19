<?php

namespace RcmUser\Log\Event;

use RcmUser\Event\AbstractListener;
use RcmUser\Log\Logger;
use Zend\EventManager\Event;

/**
 * Class AbstractLoggerListener
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
abstract class AbstractLoggerListener extends AbstractListener implements LoggerListener
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }


    /**
     * __invoke
     *
     * @param Event $event
     *
     * @return bool
     */
    public function __invoke(Event $event)
    {
        $this->logger->notice(
            $this->getMessage($event)
        );
    }

    /**
     * getMessage
     *
     * @param Event $event
     *
     * @return string
     */
    abstract protected function getMessage(Event $event);
}
