<?php

namespace RcmUser\Log\Event\UserDataService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnCreateUserFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnCreateUserFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnCreateUserFailListener
     */
    public function __invoke($container)
    {
        return new OnCreateUserFailListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
