<?php
/**
 * UserPropertyServiceListenersTest.php
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
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;
use RcmUser\User\Event\UserPropertyServiceListeners;

require_once __DIR__ . '/../../../Zf2TestCase.php';

/**
 * Class UserPropertyServiceListenersTest
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
 * @covers    \RcmUser\User\Event\UserPropertyServiceListeners
 */
class UserPropertyServiceListenersTest extends Zf2TestCase
{
    /**
     * @var \RcmUser\User\Event\UserPropertyServiceListeners $userPropertyServiceListeners
     */
    public $userPropertyServiceListeners;

    public $mockEvent;


    /**
     * buildEventManager
     *
     * @return void
     */
    public function buildEventManager()
    {
        //
        $this->mockEventManagerInterface = $this->getMockBuilder(
            '\Zend\EventManager\EventManagerInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->mockEventManagerInterface->expects($this->any())
            ->method('getSharedManager')
            ->will($this->returnValue($this->mockEventManagerInterface));

        $this->mockEventManagerInterface->expects($this->any())
            ->method('detach')
            ->will($this->returnValue(true));
    }

    public function buildSuccessCase()
    {
        $this->mockEventReturn = array(
            array('propertyNameSpace', null, UserRoleProperty::PROPERTY_KEY),
            array('data', null, new UserRoleProperty(array('SOME', 'ROLES'))),
            array('user', null, new User('123'))
        );

        $this->mockEvent = $this->getMockBuilder(
            '\Zend\EventManager\EventInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockEvent->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnValueMap(
                    $this->mockEventReturn
                )
            );

        //
        $this->buildEventManager();

        //
        $this->userPropertyServiceListeners = new UserPropertyServiceListeners();
    }

    public function buildFailCase1()
    {
        $this->mockEventReturn = array(
            array('propertyNameSpace', null, 'NOPE'),
            array('data', null, new UserRoleProperty(array('SOME', 'ROLES'))),
            array('user', null, new User('123'))
        );

        $this->mockEvent = $this->getMockBuilder(
            '\Zend\EventManager\EventInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockEvent->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnValueMap(
                    $this->mockEventReturn
                )
            );

        //
        $this->buildEventManager();

        //
        $this->userPropertyServiceListeners = new UserPropertyServiceListeners();
    }

    public function buildFailCase2()
    {
        $this->mockEventReturn = array(
            array('propertyNameSpace', null, UserRoleProperty::PROPERTY_KEY),
            array('data', null, 'NOPE'),
            array('user', null, new User('123'))
        );

        $this->mockEvent = $this->getMockBuilder(
            '\Zend\EventManager\EventInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockEvent->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnValueMap(
                    $this->mockEventReturn
                )
            );

        //
        $this->buildEventManager();

        //
        $this->userPropertyServiceListeners = new UserPropertyServiceListeners();
    }

    public function test()
    {
        $this->buildSuccessCase();

        $pk = $this->userPropertyServiceListeners->getUserPropertyKey();

        $this->assertEquals(
            UserRoleProperty::PROPERTY_KEY,
            $pk
        );

        $result = $this->userPropertyServiceListeners->onPopulateUserProperty(
            $this->mockEvent
        );

        //var_dump($this->mockEvent->getParam('propertyNameSpace'));

        $this->assertInstanceOf(
            '\RcmUser\Result',
            $result
        );

        $this->buildFailCase1();

        $result = $this->userPropertyServiceListeners->onPopulateUserProperty(
            $this->mockEvent
        );

        var_dump($this->mockEvent->getParam('propertyNameSpace'));

        $this->assertFalse(
            $result
        );

        $this->buildFailCase2();


        $result = $this->userPropertyServiceListeners->onPopulateUserProperty(
            $this->mockEvent
        );
        $this->assertInstanceOf(
            '\RcmUser\Result',
            $result
        );
        $this->assertFalse(
            $result->isSuccess()
        );

    }
}
 