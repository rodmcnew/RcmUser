<?php
/**
 * AdminApiAclDefaultUserRoleControllerTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Controller
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Controller;

use RcmUser\Test\Zf2TestCase;

require_once __DIR__ . '/../../Zf2TestCase.php';

/**
 * Class AdminApiAclDefaultUserRoleControllerTest
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Controller
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright ${YEAR} Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 * @covers
 */
class AdminApiAclDefaultUserRoleControllerTest extends Zf2TestCase
{
    /**
     * @var \RcmUser\Controller\AdminApiAclDefaultUserRoleController $controller
     */
    public $controller;

    public function XXXsetUp()
    {
        $this->mockData = array();

        $this->mockData['isAllowed'] = true;

        $this->mockData['getResponse'] = $this->getMockBuilder(
            '\Zend\Http\Response'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockData['getServiceLocator'] = $this->getMockServiceLocator();

        return $this->mockData['getJsonResponse'] = json_encode(
            array('test', 'data')
        );
    }

    /**
     * buildSuccess
     *
     * @return void
     */
    public function buildSuccess()
    {

        $this->controller = new WrapperAdminAclController($this->mockData);
    }

    /**
     * buildFail
     *
     * @return void
     */
    public function buildFail()
    {
        $mocks = array();

        $mocks['isAllowed'] = false;

        $mocks['getResponse'] = $this->getMockBuilder(
            '\Zend\Http\Response'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new WrapperAdminAclController($mocks);
    }

    /**
     * test
     *
     * @return void
     */
    public function atest()
    {
        $this->buildSuccess();

        $result = $this->controller->indexAction();

        $this->assertInstanceOf(
            '\Zend\View\Model\ViewModel',
            $result
        );

        $this->buildFail();

        $result = $this->controller->indexAction();

        $this->assertInstanceOf(
            '\Zend\Http\Response',
            $result
        );
    }
}

/**
 * Class WrapperAdminApiAclDefaultUserRoleController
 *
 * WRAPPER
 *
 * class WrapperAdminApiAclDefaultUserRoleController extends AdminApiAclDefaultUserRoleController
 * {
 *
 * public $mockData = array();
 *
 * public function __construct($mockData = array())
 * {
 * $this->mockData = $mockData;
 * }
 *
 * public function isAllowed(
 * $resourceId = RcmUserAclResourceProvider::RESOURCE_ID_ROOT,
 * $privilege = null
 * ) {
 * return $this->mockData['isAllowed'];
 * }
 *
 * public function getResponse()
 * {
 * return $this->mockData['getResponse'];
 * }
 *
 * public function getServiceLocator()
 * {
 * return $this->mockData['getServiceLocator'];
 * }
 *
 * public function getJsonResponse()
 * {
 * return $this->mockData['getJsonResponse'];
 * }
 * }
 * */