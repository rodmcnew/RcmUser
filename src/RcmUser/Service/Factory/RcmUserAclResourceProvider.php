<?php
/**
 * RcmUserAclResourceProvider.php
 *
 * RcmUserAclResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Service\Factory;

use RcmUser\Acl\Entity\AclResource;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * RcmUserAclResourceProvider
 *
 * RcmUserAclResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserAclResourceProvider implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Provider\RcmUserAclResourceProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $rcmResources = array();

        /* parent resource example */
        $rcmResources['rcmuser']
            = new AclResource(
            'rcmuser'
        );
        $rcmResources['rcmuser']->setName('RCM User');
        $rcmResources['rcmuser']->setDescription('All RCM user access.');

        $rcmResources['rcmuser-user-administration']
            = new AclResource(
            'rcmuser-user-administration',
            'rcmuser',
            array('read', 'write')
        );
        $rcmResources['rcmuser-user-administration']->setName('User Administration');
        $rcmResources['rcmuser-user-administration']->setDescription('Allows the editing of user data.');

        $rcmResources['rcmuser-acl-administration']
            = new AclResource(
            'rcmuser-acl-administration',
            'rcmuser',
            array()
        );
        $rcmResources['rcmuser-acl-administration']->setName('Role and Access Administration');
        $rcmResources['rcmuser-acl-administration']->setDescription('Allows the editing of user roles data.');

        $service = new \RcmUser\Provider\RcmUserAclResourceProvider($rcmResources);

        return $service;
    }
}