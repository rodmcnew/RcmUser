<?php

namespace RcmUser\Log\Event;

use RcmUser\Log\Logger;

/**
 * Class AbstractLoggerListener
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
abstract class AbstractLoggerListener implements LoggerListener
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
}
