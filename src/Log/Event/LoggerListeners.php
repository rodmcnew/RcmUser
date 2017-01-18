<?php

namespace RcmUser\Log\Event;

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
     * @param array $config
     */
    public function __construct(
        $config
    ) {
        parent::__construct(
            $config['RcmUser'][static::class]
        );
    }
}
