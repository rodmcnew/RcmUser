<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnAddUserRoleListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnAddUserRoleListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnAddUserRoleListener
     */
    public function __invoke($container)
    {
        return new OnAddUserRoleListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
