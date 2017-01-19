<?php

namespace RcmUser\Log\Event\UserDataService;

use Interop\Container\ContainerInterface;
use RcmUser\Log\Logger;
use RcmUser\Service\RcmUserService;

/**
 * Class OnDeleteUserFailListenerFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class OnDeleteUserFailListenerFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return OnDeleteUserFailListener
     */
    public function __invoke($container)
    {
        return new OnDeleteUserFailListener(
            $container->get(Logger::class),
            $container->get(RcmUserService::class)
        );
    }
}
