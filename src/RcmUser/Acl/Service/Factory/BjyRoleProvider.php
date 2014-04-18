<?php
/**
 * BjyResourceProvider.php
 *
 * BjyResourceProvider
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
 * BjyRoleProvider
 *
 * BjyRoleProvider Factory
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
class BjyRoleProvider implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Acl\Provider\BjyRoleProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $aclRoleDataMapper = $serviceLocator->get('RcmUser\Acl\AclRoleDataMapper');

        $service = new \RcmUser\Acl\Provider\BjyRoleProvider();
        $service->setAclRoleDataMapper($aclRoleDataMapper);

        return $service;
    }
}