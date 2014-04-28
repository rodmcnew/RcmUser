<?php
/**
 * TestRcmUserService.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUserTest\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUserTest\Service;


require_once __DIR__ . '/../ZF2TestCase.php';

use RcmUser\Acl\Service\UserAuthorizeService;
use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\Config\Config;
use RcmUser\Service\RcmUserService;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use RcmUser\User\Service\UserDataService;
use RcmUser\User\Service\UserPropertyService;
use RcmUser\Zf2TestCase;
use Zend\Di\ServiceLocator;

class TestRcmUserService extends Zf2TestCase
{
    public $rcmUserService;

    public function setUp()
    {
        $this->addModule('RcmUser');
        parent::setUp();
    }

    protected function getNewUser($prefix = 'A')
    {
        $user = new User();
        $user->setId($prefix . '_id');
        $user->setUsername($prefix . '_username');
        $user->setPassword($prefix . '_password');
        $user->setState($prefix . '_state');
        $user->setProperties(array('property1', $prefix . '_property1'));
        $user->setProperty('property2', $prefix . '_property2');

        return $user;
    }

    public function getRcmUserService()
    {
        if(!isset($this->rcmUserService)){

            $this->buildRcmUserService();
        }

        return $this->rcmUserService;
    }

    public function buildRcmUserService()
    {

        $config = new Config();
        $serviceLocator = new ServiceLocator();
        $user = $this->getNewUser();
        $userResult = new Result($user);

        /*
        $userDataService = new UserDataService();
        $userPropertyService = new UserPropertyService();
        $userAuthService = new UserAuthenticationService();
        $userAuthorizeService = new UserAuthorizeService($config, $serviceLocator);
        */

        $userDataService = $this->getMockBuilder(
            '\RcmUser\User\Service\UserDataService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $userDataService->expects($this->any())
            ->method('buildUser')
            ->will($this->returnValue($userResult));
        $userDataService->expects($this->any())
            ->method('readUser')
            ->will($this->returnValue($userResult));
        $userDataService->expects($this->any())
            ->method('createUser')
            ->will($this->returnValue($userResult));
        $userDataService->expects($this->any())
            ->method('updateUser')
            ->will($this->returnValue($userResult));
        $userDataService->expects($this->any())
            ->method('deleteUser')
            ->will($this->returnValue($userResult));

        /////
        $userPropertyService = $this->getMockBuilder(
            '\RcmUser\User\Service\UserPropertyService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $userPropertyService->expects($this->any())
            ->method('getUserProperty')
            ->will($this->returnValue(array('some', 'user', 'property')));

        /////
        $userAuthService = $this->getMockBuilder(
            '\RcmUser\Authentication\Service\UserAuthenticationService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $userAuthService->expects($this->any())
            ->method('getIdentity')
            ->will($this->returnValue($user));

        /////
        $userAuthorizeService = $this->getMockBuilder(
            '\RcmUser\Acl\Service\UserAuthorizeService'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->rcmUserService = new RcmUserService();
        $this->rcmUserService->setUserDataService($userDataService);
        $this->rcmUserService->setUserPropertyService($userPropertyService);
        $this->rcmUserService->setUserAuthService($userAuthService);
        $this->rcmUserService->setUserAuthorizeService($userAuthorizeService);


        /*
        $mockObject = $this->getMockBuilder('\Aws\S3\S3Client');
        $mockObject->disableOriginalConstructor();
        $mockS3Client = $mockObject->getMock();

        $mockObject = $this
            ->getMockBuilder('\Guzzle\Service\Builder\ServiceBuilder')
            ->disableOriginalConstructor();

        $mockAwsFactory = $mockObject->getMock();
        $mockAwsFactory->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockS3Client));

        $sm = new ServiceManager();
        $sm->setService('config', $config);
        $sm->setService('aws', $mockAwsFactory);

        $factory = new S3FileStorageFactory();
        $object = $factory->createService($sm);
        */
    }

    public function testGetUser()
    {

        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->getUser($user);

        $this->assertInstanceOf('\RcmUser\User\Entity\User', $result, 'Did not return instance of Result.');

        // test no not found
    }

    public function testUserExists()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->userExists($user);

        $this->assertTrue($result, 'User was not found to exist.');

        // test for not found
    }

    public function testIsSessUser()
    {
        $user = $this->getNewUser('A');
        $user->setId(null);

        $result = $this->getRcmUserService()->isSessUser($user);

        $this->assertTrue($result, 'User did not match by username.');

        $user->setId('A_id');

        $result = $this->getRcmUserService()->isSessUser($user);

        $this->assertTrue($result, 'User did not match by id.');

        $user2 = new User();

        $result = $this->getRcmUserService()->isSessUser($user2);

        $this->assertFalse($result, 'User matched but should not have.');
    }

    public function testReadUser()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->readUser($user);

        $this->assertInstanceOf('\RcmUser\User\Result', $result, 'Did not return instance of Result.');
    }

    public function testCreateUser()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->createUser($user);

        $this->assertInstanceOf('\RcmUser\User\Result', $result, 'Did not return instance of Result.');
    }

    public function testUpdateUser()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->createUser($user);

        $this->assertInstanceOf('\RcmUser\User\Result', $result, 'Did not return instance of Result.');
    }

    public function testDeleteUser()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->createUser($user);

        $this->assertInstanceOf('\RcmUser\User\Result', $result, 'Did not return instance of Result.');
    }


    public function testGetUserProperty()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->getUserProperty($user, 'somePropertName');

        $this->assertTrue(is_array($result), 'Did not return our test array.');

        $this->assertContains('some', $result, 'Did not return our test array value.');
    }

    public function testGetCurrentUserProperty()
    {

    }

    public function testValidateCredentials()
    {

    }

    public function testAuthenticate()
    {

    }

    public function testClearIdentity()
    {

    }

    public function testGetIdentity()
    {

    }

    public function testIsAllowed()
    {

    }

    public function testBuildNewUser()
    {

    }

    public function testBuildUser()
    {

    }


}