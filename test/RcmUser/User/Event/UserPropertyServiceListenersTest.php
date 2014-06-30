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

    public $event;


    /**
     * buildEventManager
     *
     * @return void
     */
    public function buildEventManager()
    {
        //
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
    }

    public function buildSuccessCase()
    {
        $this->eventReturn = array(
            array('propertyNameSpace', null, UserRoleProperty::PROPERTY_KEY),
            array('data', null, new UserRoleProperty(array('SOME', 'ROLES'))),
            array('user', null, new User('123'))
        );

        $this->event = $this->getMockBuilder(
            '\Zend\EventManager\EventInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->event->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnValueMap(
                    $this->eventReturn
                )
            );

        //
        $this->buildEventManager();

        //
        $this->userPropertyServiceListeners = new UserPropertyServiceListeners();
    }

    public function buildFailCase1()
    {
        $this->eventReturn = array(
            array('propertyNameSpace', null, 'NOPE'),
            array('data', null, new UserRoleProperty(array('SOME', 'ROLES'))),
            array('user', null, new User('123'))
        );

        $this->event = $this->getMockBuilder(
            '\Zend\EventManager\EventInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->event->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnValueMap(
                    $this->eventReturn
                )
            );

        //
        $this->buildEventManager();

        //
        $this->userPropertyServiceListeners = new UserPropertyServiceListeners();
    }

    public function buildFailCase2()
    {
        $this->eventReturn = array(
            array('propertyNameSpace', null, UserRoleProperty::PROPERTY_KEY),
            array('data', null, 'NOPE'),
            array('user', null, new User('123'))
        );

        $this->event = $this->getMockBuilder(
            '\Zend\EventManager\EventInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->event->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnValueMap(
                    $this->eventReturn
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
            $this->event
        );

        var_dump($this->event->getParam('propertyNameSpace'));

        $this->assertInstanceOf(
            '\RcmUser\Result',
            $result
        );

        $this->buildFailCase1();

        $result = $this->userPropertyServiceListeners->onPopulateUserProperty(
            $this->event
        );

        var_dump($this->event->getParam('propertyNameSpace'));

        $this->assertFalse(
            $result
        );

        $this->buildFailCase2();


        $result = $this->userPropertyServiceListeners->onPopulateUserProperty(
            $this->event
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
 