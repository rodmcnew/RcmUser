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
    public $authorize;

    public function getAuthorizeService()
    {
        if(!isset($this->authorizeService)){

            $this->buildAuthorizeService();
        }

        return $this->authorizeService;
    }

    public function buildAuthorizeService()
    {
        $this->authorize = $this->getMockBuilder(
            'RcmUser\Acl\Service\AuthorizeService'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->authorize->expects($this->any())
            ->method('isAllowed')
            ->will($this->returnValue(true));

        $this->authorizeService = new AuthorizeService();
        $this->authorizeService->setAuthorize($this->authorize);
    }

    public function testIsAllowed()
    {
        // @todo This will be addressed on small refactor
        $resource = "some.resource";

        $result = $this->getAuthorizeService()->isAllowed($resource);

        $this->assertTrue($result, 'True not returned.');
    }

    public function testParseResource()
    {
        $resource = "some.resource";

        $result = $this->getAuthorizeService()->parseResource($resource);

        $this->assertContains('some', $result, 'Resource string not parsed correctly');
    }
}
 