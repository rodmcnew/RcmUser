<?php

namespace RcmUser\User;

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
     * createService
     *
     * @param ContainerInterface|ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return Config
     */
    public function __invoke($serviceLocator)
    {
        $config = $serviceLocator->get('RcmUser\Config');

        return new Config(
            isset($config['User\Config']) ? $config['User\Config'] : []
        );
    }
}
