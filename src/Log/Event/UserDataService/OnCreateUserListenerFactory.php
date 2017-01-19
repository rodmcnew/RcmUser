<?php

namespace RcmUser\Log\Event\UserDataService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnCreateUserListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnCreateUserListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnCreateUserListener
     */
    public function __invoke($container)
    {
        return new OnCreateUserListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
