<?php

namespace RcmUser\Log\Event\UserDataService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnUpdateUserListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnUpdateUserListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnUpdateUserListener
     */
    public function __invoke($container)
    {
        return new OnUpdateUserListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
