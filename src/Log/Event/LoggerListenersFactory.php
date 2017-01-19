<?php

namespace RcmUser\Log\Event;

use Interop\Container\ContainerInterface;

/**
 * Class LoggerListenersFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class LoggerListenersFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return LoggerListeners
     */
    public function __invoke($container)
    {
        return new LoggerListeners(
            $container,
            $container->get('Config')
        );
    }
}
