<?php

namespace RcmUser\Authentication;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ConfigFactory
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class ConfigFactory
{
    /**
     * __invoke
     *
     * @param ContainerInterface|ServiceLocatorInterface $serviceLocator
     *
     * @return object
     */
    public function __invoke($serviceLocator)
    {
        $config = $serviceLocator->get('RcmUser\Config');

        return new Config(
            isset($config['Auth\Config']) ? $config['Auth\Config'] : []
        );
    }
}
