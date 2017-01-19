<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnUpdateUserRolesListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnUpdateUserRolesListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnUpdateUserRolesListener
     */
    public function __invoke($container)
    {
        return new OnUpdateUserRolesListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
