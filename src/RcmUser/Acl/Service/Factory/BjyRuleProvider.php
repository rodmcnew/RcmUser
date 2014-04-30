<?php
/**
 * BjyRuleProvider.php
 *
 * BjyRuleProvider
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
 * BjyRuleProvider
 *
 * BjyRuleProvider Factory
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
class BjyRuleProvider implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return mixed|\RcmUser\Acl\Provider\BjyRuleProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $aclRuleDataMapper = $serviceLocator->get('RcmUser\Acl\AclRuleDataMapper');

        $service = new \RcmUser\Acl\Provider\BjyRuleProvider();
        $service->setRuleDataMapper($aclRuleDataMapper);

        return $service;
    }
}