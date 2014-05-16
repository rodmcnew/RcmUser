<?php
 /**
 * AuthorizeServiceTest.php
 *
 * TEST
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Acl\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Acl\Service;

use RcmUser\Acl\Service\AuthorizeService;
use RcmUser\Result;
use RcmUser\Zf2TestCase;
use Zend\Di\ServiceLocator;

require_once __DIR__ . '/../../../Zf2TestCase.php';

/**
 * Class AuthorizeServiceTest
 *
 * TEST
 *
 * PHP version 5
 *
 * @covers \RcmUser\Acl\Service\AuthorizeService
 */
class AuthorizeServiceTest extends Zf2TestCase {

    public $authorizeService;

    public function getAuthorizeService()
    {
        if(!isset($this->authorizeService)){

            $this->buildAuthorizeService();
        }

        return $this->authorizeService;
    }

    public function buildAuthorizeService()
    {
        /*
        $this->authorize = $this->getMockBuilder(
            'RcmUser\Acl\Service\AuthorizeService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->authorize->expects($this->any())
            ->method('isAllowed')
            ->will($this->returnValue(true));
        */
        $this->authorizeService = new AuthorizeService();

        $aclResourceService = $this->getMockBuilder(
            'RcmUser\Acl\Service\AclResourceService'
        )
            ->disableOriginalConstructor()
            ->getMock();


        $aclRoleDataMapper = $this->getMockBuilder(
            'RcmUser\Acl\Db\AclRoleDataMapper'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $aclRoleDataMapper->expects($this->any())
        ->method('fetchAll')
        ->will($this->returnValue(new Result(array('data' => 'here'), Result::CODE_SUCCESS, 'Message')));


        $aclRuleDataMapper =  $this->getMockBuilder(
            'RcmUser\Acl\Db\AclRuleDataMapper'
        )
            ->disableOriginalConstructor()
            ->getMock();


        $this->authorizeService->setAclResourceService($aclResourceService);
        $this->authorizeService->setAclRoleDataMapper($aclRoleDataMapper);
        $this->authorizeService->setAclRuleDataMapper($aclRuleDataMapper);
        $this->authorizeService->setSuperAdminRole('admin');
    }

    public function testGetSet(){

        $this->buildAuthorizeService();

        $authServ = $this->getAuthorizeService();

        $result = $authServ->getAclResourceService();
        //var_dump($result);
        $this->assertInstanceOf('\RcmUser\Acl\Service\AclResourceService', $result, "Getter or Setter failed");
        $this->assertInstanceOf('\RcmUser\Acl\Db\AclRoleDataMapper', $authServ->getAclRoleDataMapper(), "Getter or Setter failed");
        $this->assertInstanceOf('\RcmUser\Acl\Db\AclRuleDataMapper', $authServ->getAclRuleDataMapper(), "Getter or Setter failed");
        $this->assertEquals('admin',$authServ->getSuperAdminRole(), "Getter or Setter failed");

    }

    public function testGetRoles(){}

    public function testIsAllowed()
    {
        /* @todo Fix Me
        $resource = "some.resource";

        $result = $this->getAuthorizeService()->isAllowed($resource);

        $this->assertTrue($result, 'True not returned.');
         * */
    }

    public function testParseResource()
    {
        $resource = "some.resource";

        $result = $this->getAuthorizeService()->parseResource($resource);

        $this->assertContains('some', $result, 'Resource string not parsed correctly');
    }
}
 