<?php
/**
 * RcmUserBuildHtmlHeadTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\View\Helper
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\View\Helper;

require_once __DIR__ . '/../../../Zf2TestCase.php';
require_once __DIR__ . '/MockView.php';

use RcmUser\View\Helper\RcmUserBuildHtmlHead;

/**
 * Class RcmUserBuildHtmlHeadTest
 *
 * RcmUserBuildHtmlHeadTest
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\View\Helper
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserBuildHtmlHeadTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \RcmUser\View\Helper\RcmUserBuildHtmlHead $rcmUserBuildHtmlHead
     */
    public $rcmUserBuildHtmlHead;

    /**
     * @var \Zend\View\Renderer\RendererInterface
     */
    public $view;

    /**
     * test
     *
     * @return void
     */
    public function test()
    {

        $this->view = $this->getMockBuilder(
            'RcmUser\Test\View\Helper\MockView'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->view->expects($this->any())
            ->method('rcmIncludeAngularJsUiBootstrap')
            ->will($this->returnValue('rcmIncludeAngularJsUiBootstrap'));
        $this->view->expects($this->any())
            ->method('rcmIncludeAngularJs')
            ->will($this->returnValue('rcmIncludeAngularJs'));
        $this->view->expects($this->any())
            ->method('rcmIncludeTwitterBootstrap')
            ->will($this->returnValue('rcmIncludeTwitterBootstrap'));

        $this->rcmUserBuildHtmlHead = new RcmUserBuildHtmlHead();

        $this->rcmUserBuildHtmlHead->setView($this->view);

        $this->rcmUserBuildHtmlHead->__invoke();
    }


}