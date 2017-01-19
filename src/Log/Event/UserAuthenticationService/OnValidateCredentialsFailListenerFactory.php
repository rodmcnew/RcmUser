<?php

namespace RcmUser\Log\Event\UserAuthenticationService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnValidateCredentialsFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnValidateCredentialsFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnValidateCredentialsFailListener
     */
    public function __invoke($container)
    {
        return new OnValidateCredentialsFailListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
