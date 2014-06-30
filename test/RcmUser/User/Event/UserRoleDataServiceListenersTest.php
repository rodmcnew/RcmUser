<?php
/**
 * UserRoleDataServiceListenersTest.php
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

use RcmUser\Result;
use RcmUser\Test\Zf2TestCase;
use RcmUser\User\Entity\UserRoleProperty;
use RcmUser\User\Event\UserRoleDataServiceListeners;

require_once __DIR__ . '/../../../Zf2TestCase.php';

/**
 * Class UserRoleDataServiceListenersTest
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
 * @covers    \RcmUser\User\Event\UserRoleDataServiceListeners
 */
class UserRoleDataServiceListenersTest extends Zf2TestCase
{
    /**
     * @var \RcmUser\User\Event\UserRoleDataServiceListeners $userRoleDataServiceListeners
     */
    public $userRoleDataServiceListeners;

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

    /**
     * buildUserRoleService
     *
     * @param string $case
     *
     * @return void
     */
    public function buildUserRoleService($case = 'success')
    {
        if ($case == 'success') {
            $this->mockRoles = array('SOME', 'ROLES');
            $this->mockResult = new Result($this->mockRoles);
            $this->mockDefaultResult = new Result(array('DEFAULT', 'ROLES'));
        } else {


        }


        //
        $this->userRoleService = $this->getMockBuilder(
            '\RcmUser\User\Service\UserRoleService'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->userRoleService->expects($this->any())
            ->method('readRoles')
            ->will(
                $this->returnValue(
                    $this->mockResult
                )
            );

        $this->userRoleService->expects($this->any())
            ->method('createRoles')
            ->will(
                $this->returnValue(
                    $this->mockResult
                )
            );

        $this->userRoleService->expects($this->any())
            ->method('updateRoles')
            ->will(
                $this->returnValue(
                    $this->mockResult
                )
            );

        $this->userRoleService->expects($this->any())
            ->method('deleteRoles')
            ->will(
                $this->returnValue(
                    $this->mockResult
                )
            );

        $this->userRoleService->expects($this->any())
            ->method('getDefaultUserRoleIds')
            ->will(
                $this->returnValue(
                    $this->mockDefaultResult
                )
            );

        $this->userRoleService->expects($this->any())
            ->method('buildUserRoleProperty')
            ->will(
                $this->returnValue(
                    new UserRoleProperty($this->mockRoles)
                )
            );

        $this->userRoleService->expects($this->any())
            ->method('buildValidUserRoleProperty')
            ->will(
                $this->returnValue(
                    new UserRoleProperty($this->mockRoles)
                )
            );

        $this->userRoleService->expects($this->any())
            ->method('buildValidRoles')
            ->will(
                $this->returnValue(
                    $this->mockRoles
                )
            );
    }

    public function buildEvent($case = 'success')
    {
        if($case == 'success'){
            $this->eventReturn = array(
                array('result', null, array(new User('123'))),
                array('data', null, new UserRoleProperty(array('SOME', 'ROLES'))),
                array('requestUser', null, new User('123')),
                array('responseUser', null, new User('123')),
                array('existingUser', null, new User('123'))
            );
        } else {

            
        }

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
        //$this->buildEventManager();

        //
        $this->buildUserRoleService();

        //
        $this->userRoleDataServiceListeners = new UserRoleDataServiceListeners();

        $this->userRoleDataServiceListeners->setUserRoleService(
            $this->userRoleService
        );
    }

    public function testSetGet()
    {
        $this->buildSuccessCase();

        $this->userRoleDataServiceListeners->setUserRoleService(
            $this->userRoleService
        );

        $this->assertInstanceOf(
            '\RcmUser\User\Service\UserRoleService',
            $this->userRoleDataServiceListeners->getUserRoleService()
        );

        $this->assertEquals(
            UserRoleProperty::PROPERTY_KEY,
            $this->userRoleDataServiceListeners->getUserPropertyKey()
        );
    }

}
 