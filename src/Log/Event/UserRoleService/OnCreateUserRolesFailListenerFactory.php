<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnCreateUserRolesFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnCreateUserRolesFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnCreateUserRolesFailListener
     */
    public function __invoke($container)
    {
        return new OnCreateUserRolesFailListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
