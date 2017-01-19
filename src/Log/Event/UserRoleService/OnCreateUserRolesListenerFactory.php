<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnCreateUserRolesListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnCreateUserRolesListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnCreateUserRolesListener
     */
    public function __invoke($container)
    {
        return new OnCreateUserRolesListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
