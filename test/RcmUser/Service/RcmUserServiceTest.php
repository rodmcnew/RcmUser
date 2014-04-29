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

namespace RcmUser\Test\Service;

use RcmUser\Acl\Service\UserAuthorizeService;
use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\Config\Config;
use RcmUser\Service\RcmUserService;
use RcmUser\User\Entity\User;
use RcmUser\User\Service\UserDataService;
use RcmUser\User\Service\UserPropertyService;
use RcmUser\Zf2TestCase;
use Zend\Di\ServiceLocator;


require_once __DIR__ . '/../ZF2TestCase.php';

class RcmUserServiceTest extends Zf2TestCase
{
    public $rcmUserService;
    public $userDataService;
    public $userPropertyService;
    public $userAuthService;
    public $userAuthorizeService;



    public function setUp()
    {
        $this->buildRcmUserService();

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
        /*
        $config = new Config();
        $serviceLocator = new ServiceLocator();
        */

        $user = $this->getNewUser();
        $userResult = new \RcmUser\User\Result($user);
        $authResult = new \Zend\Authentication\Result(\Zend\Authentication\Result::SUCCESS, $user);

        /*
        $userDataService = new UserDataService();
        $userPropertyService = new UserPropertyService();
        $userAuthService = new UserAuthenticationService();
        $userAuthorizeService = new UserAuthorizeService($config, $serviceLocator);
        */

        $this->userDataService = $this->getMockBuilder(
            '\RcmUser\User\Service\UserDataService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->userDataService->expects($this->any())
            ->method('buildUser')
            ->will($this->returnValue($userResult));
        $this->userDataService->expects($this->any())
            ->method('readUser')
            ->will($this->returnValue($userResult));
        $this->userDataService->expects($this->any())
            ->method('createUser')
            ->will($this->returnValue($userResult));
        $this->userDataService->expects($this->any())
            ->method('updateUser')
            ->will($this->returnValue($userResult));
        $this->userDataService->expects($this->any())
            ->method('deleteUser')
            ->will($this->returnValue($userResult));

        /////
        $this->userPropertyService = $this->getMockBuilder(
            '\RcmUser\User\Service\UserPropertyService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->userPropertyService->expects($this->any())
            ->method('getUserProperty')
            ->will($this->returnValue(array('some', 'user', 'property')));

        /////
        $this->userAuthService = $this->getMockBuilder(
            '\RcmUser\Authentication\Service\UserAuthenticationService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->userAuthService->expects($this->any())
            ->method('getIdentity')
            ->will($this->returnValue($user));
        $this->userAuthService->expects($this->any())
            ->method('validateCredentials')
            ->will($this->returnValue($authResult));
        $this->userAuthService->expects($this->any())
            ->method('authenticate')
            ->will($this->returnValue($authResult));
        $this->userAuthService->expects($this->any())
            ->method('clearIdentity')
            ->will($this->returnValue(true));
        $this->userAuthService->expects($this->any())
            ->method('getIdentity')
            ->will($this->returnValue($user));

        /////
        $this->userAuthorizeService = $this->getMockBuilder(
            '\RcmUser\Acl\Service\UserAuthorizeService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->userAuthorizeService->expects($this->any())
            ->method('isAllowed')
            ->will($this->returnValue(true));

        $this->rcmUserService = new RcmUserService();
        $this->rcmUserService->setUserDataService($this->userDataService);
        $this->rcmUserService->setUserPropertyService($this->userPropertyService);
        $this->rcmUserService->setUserAuthService($this->userAuthService);
        $this->rcmUserService->setUserAuthorizeService($this->userAuthorizeService);

    }

    public function testSetGetUserDataService()
    {
        $rcmUserService = new RcmUserService();

        $rcmUserService->setUserDataService($this->userDataService);

        $service = $rcmUserService->getUserDataService();

        $this->assertInstanceOf(
            '\RcmUser\User\Service\UserDataService',
            $service,
            'Getter or setter failed.'
        );
    }

    public function testSetGetUserPropertyService()
    {
        $rcmUserService = new RcmUserService();

        $rcmUserService->setUserPropertyService($this->userPropertyService);

        $service = $rcmUserService->getUserPropertyService();

        $this->assertInstanceOf(
            '\RcmUser\User\Service\UserPropertyService',
            $service,
            'Getter or setter failed.'
        );
    }

    public function testSetGetUserAuthService()
    {
        $rcmUserService = new RcmUserService();

        $rcmUserService->setUserAuthService($this->userAuthService);

        $service = $rcmUserService->getUserAuthService();

        $this->assertInstanceOf(
            '\RcmUser\Authentication\Service\UserAuthenticationService',
            $service,
            'Getter or setter failed.'
        );
    }

    public function testSetGetUserAuthorizeService()
    {
        $rcmUserService = new RcmUserService();

        $rcmUserService->setUserAuthorizeService($this->userAuthorizeService);

        $service = $rcmUserService->getUserAuthorizeService();

        $this->assertInstanceOf(
            '\RcmUser\Acl\Service\UserAuthorizeService',
            $service,
            'Getter or setter failed.'
        );
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

        $result = $this->getRcmUserService()->getCurrentUserProperty('somePropertName');

        $this->assertTrue(is_array($result), 'Did not return our test array.');

        $this->assertContains('some', $result, 'Did not return our test array value.');
    }

    public function testValidateCredentials()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->validateCredentials($user);

        $this->assertInstanceOf('\Zend\Authentication\Result', $result, 'Did not return instance of Result.');
    }

    public function testAuthenticate()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->authenticate($user);

        $this->assertInstanceOf('\Zend\Authentication\Result', $result, 'Did not return instance of Result.');
    }

    public function testClearIdentity()
    {
        $result = $this->getRcmUserService()->clearIdentity('somePropertName');

        $this->assertTrue($result, 'Did not return true.');
    }

    public function testGetIdentity()
    {
        $result = $this->getRcmUserService()->getIdentity();

        $this->assertInstanceOf('\RcmUser\User\Entity\User', $result, 'Did not return instance of Result.');
    }

    public function testIsAllowed()
    {
        $result = $this->getRcmUserService()->isAllowed('someResource');

        $this->assertTrue($result, 'Did not return true.');
    }

    public function testBuildNewUser()
    {
        $result = $this->getRcmUserService()->buildNewUser();

        $this->assertInstanceOf('\RcmUser\User\Entity\User', $result, 'Did not return instance of Result.');
    }

    public function testBuildUser()
    {
        $user = $this->getNewUser();

        $result = $this->getRcmUserService()->buildUser($user);

        $this->assertInstanceOf('\RcmUser\User\Entity\User', $result, 'Did not return instance of Result.');
    }


}