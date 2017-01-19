<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnDeleteUserRolesListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnDeleteUserRolesListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnDeleteUserRolesListener
     */
    public function __invoke($container)
    {
        return new OnDeleteUserRolesListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
