<?php

namespace RcmUser\Log\Event\UserRoleService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnRemoveUserRoleFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnRemoveUserRoleFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnRemoveUserRoleFailListener
     */
    public function __invoke($container)
    {
        return new OnRemoveUserRoleFailListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
