<?php

namespace RcmUser\User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DoctrineUserDataMapper
 *
 * DoctrineUserDataMapper
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
class DoctrineUserDataMapper implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return \RcmUser\User\Db\DoctrineUserDataMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(
            \Doctrine\ORM\EntityManager::class
        );
        $udp = $serviceLocator->get(
            \RcmUser\User\Data\UserDataPreparer::class
        );
        $udv = $serviceLocator->get(
            \RcmUser\User\Data\UserValidator::class
        );

        $service = new \RcmUser\User\Db\DoctrineUserDataMapper();
        $service->setEntityManager($em);
        $service->setEntityClass(
            \RcmUser\User\Entity\DoctrineUser::class
        );
        $service->setUserDataPreparer($udp);
        $service->setUserValidator($udv);

        return $service;
    }
}
