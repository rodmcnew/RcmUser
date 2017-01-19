<?php

namespace RcmUser\Log\Event;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;

/**
 * Class OnAuthenticateFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnAuthenticateFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnAuthenticateFailListener
     */
    public function __invoke($container)
    {
        return new OnAuthenticateFailListener(
            Logger::class
        );
    }
}
