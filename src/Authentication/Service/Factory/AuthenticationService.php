<?php

namespace RcmUser\Authentication\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * AuthenticationService.php
 *
 * AuthenticationService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AuthenticationService implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Authentication\Service\AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $storage = $serviceLocator->get(
            \RcmUser\Authentication\Storage\Session::class
        );
        $adapter = $serviceLocator->get(
            \RcmUser\Authentication\Adapter\Adapter::class
        );

        return new \RcmUser\Authentication\Service\AuthenticationService($storage, $adapter);
    }
}
