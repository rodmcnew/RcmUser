<?php

namespace RcmUser\Log\Event\UserDataService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnUpdateUserFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnUpdateUserFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnUpdateUserFailListener
     */
    public function __invoke($container)
    {
        return new OnUpdateUserFailListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
