<?php
/**
 * UserAuthorizeService.php
 *
 * UserAuthorizeService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Service\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * UserAuthorizeService
 *
 * UserAuthorizeService Factory
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserAuthorizeService implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return \RcmUser\Acl\Service\UserAuthorizeService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new \RcmUser\Acl\Service\UserAuthorizeService();
        $service->setAuthorize($serviceLocator->get('BjyAuthorize\Service\Authorize'));

        return $service;
    }

} 