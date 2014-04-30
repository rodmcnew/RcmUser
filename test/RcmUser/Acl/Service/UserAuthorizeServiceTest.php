<?php
 /**
 * UserAuthorizeServiceTest.php
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

use RcmUser\Acl\Service\UserAuthorizeService;
use RcmUser\Zf2TestCase;
use Zend\Di\ServiceLocator;

require_once __DIR__ . '/../../../Zf2TestCase.php';

/**
 * Class UserAuthorizeServiceTest
 *
 * TEST
 *
 * PHP version 5
 *
 * @covers \RcmUser\Acl\Service\UserAuthorizeService
 */
class UserAuthorizeServiceTest extends Zf2TestCase {

    public $userAuthorizeService;
    public $authorize;

    public function getUserAuthorizeService()
    {
        if(!isset($this->userAuthorizeService)){

            $this->buildUserAuthorizeService();
        }

        return $this->userAuthorizeService;
    }

    public function buildUserAuthorizeService()
    {
        $this->authorize = $this->getMockBuilder(
            '\BjyAuthorize\Service\Authorize'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $this->authorize->expects($this->any())
            ->method('isAllowed')
            ->will($this->returnValue(true));

        $this->userAuthorizeService = new UserAuthorizeService();
        $this->userAuthorizeService->setAuthorize($this->authorize);
    }

    public function testIsAllowed()
    {
        // @todo This will be addressed on small refactor
        $resource = "some.resource";

        $result = $this->getUserAuthorizeService()->isAllowed($resource);

        $this->assertTrue($result, 'True not returned.');
    }

    public function testParseResource()
    {
        $resource = "some.resource";

        $result = $this->getUserAuthorizeService()->parseResource($resource);

        $this->assertContains('some', $result, 'Resource string not parsed correctly');
    }
}
 