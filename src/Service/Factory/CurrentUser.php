<?php

namespace RcmUser\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CurrentUser
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CurrentUser implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return array|mixed|object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \RcmUser\Authentication\Service\UserAuthenticationService $authServ */
        $authServ = $serviceLocator->get(
            \RcmUser\Authentication\Service\UserAuthenticationService::class
        );

        return new \RcmUser\Service\CurrentUser($authServ);
    }
}
