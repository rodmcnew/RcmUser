<?php

namespace RcmUser\Log\Event\UserDataService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnDeleteUserListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnDeleteUserListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnDeleteUserListener
     */
    public function __invoke($container)
    {
        return new OnDeleteUserListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
