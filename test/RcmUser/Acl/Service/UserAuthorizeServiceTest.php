<?php
 /**
 * UserAuthorizeServiceTest.php
 *
 * LongDescHere
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

require_once __DIR__ . '/../../ZF2TestCase.php';

class UserAuthorizeServiceTest extends Zf2TestCase {

    public $userAuthorizeService;
    public $serviceLocator;

    public function getUserAuthorizeService()
    {
        if(!isset($this->userAuthorizeService)){

            $this->buildUserAuthorizeService();
        }

        return $this->userAuthorizeService;
    }

    public function buildUserAuthorizeService()
    {
        $config = array();

        $this->serviceLocator = $this->getMockBuilder(
            '\Zend\ServiceManager\ServiceLocatorInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->acl = $this->getMockBuilder(
            '\Zend\Permissions\Acl\Acl'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->userAuthorizeService = new UserAuthorizeService($config, $this->serviceLocator);
    }

    public function testIsAllowed()
    {
        // @todo This will be addressed on small refactor
        //$resource = "some.resource";

        //$result = $this->getUserAuthorizeService()->isAllowed($resource);
    }

    public function testParseResource()
    {
        $resource = "some.resource";

        $result = $this->getUserAuthorizeService()->parseResource($resource);

        $this->assertContains('some', $result, 'Resource string not parsed correctly');
    }
}
 