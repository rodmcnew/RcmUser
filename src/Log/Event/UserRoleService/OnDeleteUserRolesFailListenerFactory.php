<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnDeleteUserRolesFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnDeleteUserRolesFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnDeleteUserRolesFailListener
     */
    public function __invoke($container)
    {
        return new OnDeleteUserRolesFailListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
