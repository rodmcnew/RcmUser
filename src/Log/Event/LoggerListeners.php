<?php

namespace RcmUser\Log\Event;

use Interop\Container\ContainerInterface;
use RcmUser\Event\AbstractConfigurableListeners;

/**
 * Class LoggerListeners
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class LoggerListeners extends AbstractConfigurableListeners
{
    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     * @param array              $config
     */
    public function __construct(
        $container,
        $config
    ) {
        parent::__construct(
            $container,
            $config['RcmUser'][static::class]
        );
    }
}
