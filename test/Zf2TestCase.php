<?php
/**
 * Zf2TestCase.php
 *
 * Zf2TestCase
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */
namespace RcmUser;

use Zend\ServiceManager\ServiceLocatorInterface;

require_once dirname(__FILE__) . '/Bootstrap.php';

/**
 * Class Zf2TestCase
 *
 * Zf2TestCase
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Zf2TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface $mockServiceLocator
     */
    public $mockServiceLocator;

    /**
     * getMockServiceLoactor
     *
     * @return void
     */
    public function getMockServiceLoactor()
    {
        //$aclRoleDataMapper = $serviceLocator->get('RcmUser\Acl\AclRoleDataMapper');
        //$aclRuleDataMapper = $serviceLocator->get('RcmUser\Acl\AclRuleDataMapper');

        $valueMap = array(
            array('RcmUser\Config'),
            array('RcmUser\Acl\AclRoleDataMapper', 'RcmUser\Acl\AclRoleDataMapper'),
            array('RcmUser\Acl\AclRuleDataMapper', 'RcmUser\Acl\AclRuleDataMapper'),
            array('RcmUser\Acl\Config'),
            array('RcmUser\Acl\Service\AclResourceService'),
            array('RcmUser\Acl\AclDataService'),
        );

        $this->mockServiceLocator = $this->getMockBuilder(
            '\Zend\ServiceManager\ServiceLocatorInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockServiceLocator->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($valueMap));
    }

}