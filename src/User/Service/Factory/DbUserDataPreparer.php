<?php

namespace RcmUser\User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DbUserDataPreparer
 *
 * DbUserDataPreparer
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class DbUserDataPreparer implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return DbUserDataPreparer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $encrypt = $serviceLocator->get(
            \RcmUser\User\Password\Password::class
        );
        $service = new \RcmUser\User\Data\DbUserDataPreparer();
        $service->setEncryptor($encrypt);

        return $service;
    }
}
