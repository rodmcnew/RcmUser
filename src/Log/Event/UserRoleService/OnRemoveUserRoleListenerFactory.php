<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnRemoveUserRoleListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnRemoveUserRoleListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnRemoveUserRoleListener
     */
    public function __invoke($container)
    {
        return new OnRemoveUserRoleListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
