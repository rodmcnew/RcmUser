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
 * BjyResourceProvider
 *
 * BjyResourceProvider Factory
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
class BjyResourceProvider implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Acl\Provider\BjyResourceProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $resourceProvider = $serviceLocator->get(
            'RcmUser\Acl\Service\AclResourceService'
        );

        $service = new \RcmUser\Acl\Provider\BjyResourceProvider();
        $service->setRcmUserResourceProvider($resourceProvider);

        return $service;
    }
}