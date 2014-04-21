<?php
/**
 * UserDataService.php
 *
 * UserDataService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Service\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserDataService
 *
 * UserDataService
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
class UserDataService implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return UserDataService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dm = $serviceLocator->get('RcmUser\User\UserDataMapper');
        $cfg = $serviceLocator->get('RcmUser\User\Config');

        $service = new \RcmUser\User\Service\UserDataService();
        $service->setUserDataMapper($dm);
        $service->setDefaultUserState($cfg->get('DefaultUserState', 'disabled'));

        return $service;
    }
}
