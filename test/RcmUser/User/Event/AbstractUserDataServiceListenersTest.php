<?php
 /**
 * AbstractUserDataServiceListenersTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\User\Event;

use RcmUser\Test\Zf2TestCase;
use RcmUser\User\Event\AbstractUserDataServiceListeners;

require_once __DIR__ . '/../../../Zf2TestCase.php';

/**
 * Class AbstractUserDataServiceListenersTest
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright ${YEAR} Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 * @covers \RcmUser\User\Event\AbstractUserDataServiceListeners
 */
class AbstractUserDataServiceListenersTest extends Zf2TestCase {
    /**
     * @var AbstractUserDataServiceListeners $abstractUserDataServiceListeners
     */
    public $abstractUserDataServiceListeners;


    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->event = $this->getMockBuilder(
            '\Zend\EventManager\EventInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventManagerInterface = $this->getMockBuilder(
            '\Zend\EventManager\EventManagerInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->eventManagerInterface->expects($this->any())
            ->method('getSharedManager')
            ->will($this->returnValue($this->eventManagerInterface));

        $this->eventManagerInterface->expects($this->any())
            ->method('detach')
            ->will($this->returnValue(true));

        $this->abstractUserDataServiceListeners = new AbstractUserDataServiceListeners();

    }

    public function testAttachDetach()
    {
        $this->abstractUserDataServiceListeners->attach($this->eventManagerInterface);

        $this->abstractUserDataServiceListeners->detach($this->eventManagerInterface);
    }

    public function testMethods()
    {
        $result = $this->abstractUserDataServiceListeners->onBeforeGetAllUsers($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onGetAllUsers($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onGetAllUsersFail($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onGetAllUsersSuccess($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onBuildUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onBeforeCreateUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onCreateUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onCreateUserFail($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onCreateUserSuccess($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onBeforeReadUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onReadUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onReadUserFail($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onReadUserSuccess($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onBeforeUpdateUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onUpdateUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onUpdateUserFail($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onUpdateUserSuccess($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onBeforeDeleteUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onDeleteUser($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onDeleteUserFail($this->event);
        $this->assertFalse($result->isSuccess());

        $result = $this->abstractUserDataServiceListeners->onDeleteUserSuccess($this->event);
        $this->assertFalse($result->isSuccess());
    }
}
 