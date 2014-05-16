<?php
/**
 * AclResourceService.php
 *
 * AclResourceService
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

use RcmUser\Acl\Entity\AclResource;
use RcmUser\Acl\Provider\ResourceProviderInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * AclResourceService
 *
 * AclResourceService Factory
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
class AclResourceService implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Acl\Service\AclResourceService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('RcmUser\Acl\Config');

        $resourceProviders = $config->get('ResourceProviders', array());
        $providers = array();

        foreach ($resourceProviders as $providerId => $providerData) {

            $provider = $this->buildValidProvider($serviceLocator, $providerId, $providerData);

            $providers[$provider->getProviderId()] = $provider;
        }

        $rootPrivileges = array(
            'read',
            'update',
            'create',
            'delete',
            'execute',
        );

        $rootResource = new AclResource('root', null, $rootPrivileges);
        $rootResource->setName('Root');
        $rootResource->setDescription(
            'This is the lowest level resource.  ' .
            'Access to this will allow access to all resources.'
        );

        $service = new \RcmUser\Acl\Service\AclResourceService($rootResource);
        $service->setResourceProviders($providers);

        return $service;
    }

    protected function buildValidProvider($serviceLocator, $providerId, $providerData)
    {
        if(is_string($providerData)){

            // assumes providerId is set in factory

            return $serviceLocator->get($providerData);
        }

        if (is_array($providerData)) {

            return new ResourceProvider($providerId, $providerData);
        }

        if ($providerData instanceof ResourceProviderInterface) {

            return $providerData;
        }

        throw new RcmUserException(
            'ResourceProvider is not valid: ' . var_export($providerData, true)
        );

    }
}