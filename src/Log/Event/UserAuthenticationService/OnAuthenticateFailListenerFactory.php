<?php

namespace RcmUser\Log\Event\UserAuthenticationService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

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
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
