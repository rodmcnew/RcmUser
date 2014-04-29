<?php
/**
 * TestUserDataService.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\User\Service;

use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use RcmUser\User\Service\UserDataService;
use RcmUser\Zf2TestCase;
use Zend\EventManager\EventManager;

require_once __DIR__ . '/../../ZF2TestCase.php';

class UserDataServiceTest extends Zf2TestCase
{

    public $userDataService;
    public $eventManager;
    public $responseCollection;

    public function getUserDataService()
    {
        if (!isset($this->userDataService)) {

            $this->buildUserDataService();
        }

        return $this->userDataService;
    }

    public function buildUserDataService()
    {
        $this->userDataService = new UserDataService();
        $user = new User();
        $user->setId('123');
        $result = new Result($user);

        $this->responseCollection = $this->getMockBuilder(
            '\Zend\EventManager\ResponseCollection'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->responseCollection->expects($this->any())
            ->method('last')
            ->will($this->returnValue($result));
        $this->responseCollection->expects($this->any())
            ->method('stopped')
            ->will($this->returnValue(false));

        //$this->eventManager = new EventManager('test');
        $this->eventManager = $this->getMockBuilder(
            '\Zend\EventManager\EventManagerInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->eventManager->expects($this->any())
            ->method('trigger')
            ->will($this->returnValue($this->responseCollection));

        $this->userDataService->setEventManager($this->eventManager);
    }

    public function testBuildUser()
    {
        $user = new User();

        $result = $this->getUserDataService()->buildUser($user);

        $this->assertInstanceOf(
            '\RcmUser\User\Result', $result, 'Valid result not returned'
        );
    }

    public function testCreateUser()
    {
        $user = new User();

        $result = $this->getUserDataService()->createUser($user);

        $this->assertInstanceOf(
            '\RcmUser\User\Result', $result, 'Valid result not returned'
        );
    }

    public function testReadUser()
    {
        $user = new User();

        $result = $this->getUserDataService()->readUser($user);

        $this->assertInstanceOf(
            '\RcmUser\User\Result', $result, 'Valid result not returned'
        );
    }

    public function testUpdateUser()
    {
        $user = new User();

        $result = $this->getUserDataService()->updateUser($user);

        $this->assertInstanceOf(
            '\RcmUser\User\Result', $result, 'Valid result not returned'
        );
    }

    public function testDeleteUser()
    {
        $user = new User();

        $result = $this->getUserDataService()->deleteUser($user);

        $this->assertInstanceOf(
            '\RcmUser\User\Result', $result, 'Valid result not returned'
        );
    }

}
 