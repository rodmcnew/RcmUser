<?php
/**
 * RcmUserAclResourceProviderTest.php
 *
 * TEST
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Provider;

use RcmUser\Acl\Entity\AclResource;
use RcmUser\Provider\RcmUserAclResourceProvider;
use RcmUser\Zf2TestCase;

require_once __DIR__ . '/../../Zf2TestCase.php';

class RcmUserAclResourceProviderTest extends Zf2TestCase
{

    /**
     * @var $rcmUserAclResourceProvider \RcmUser\Provider\RcmUserAclResourceProvider
     */
    public $rcmUserAclResourceProvider;

    /**
     * buildRcmUserAclResourceProvider
     *
     * @return RcmUserAclResourceProvider
     */
    public function buildRcmUserAclResourceProvider()
    {
        $this->rcmUserAclResourceProvider = new RcmUserAclResourceProvider();

        return $this->rcmUserAclResourceProvider;
    }

    /**
     * testGetSet
     *
     * @return void
     */
    public function testGetSet()
    {
        $this->buildRcmUserAclResourceProvider();

        $providerId = 'test';

        $this->rcmUserAclResourceProvider->setProviderId($providerId);

        $getProviderId = $this->rcmUserAclResourceProvider->getProviderId();

        $this->assertEquals($providerId, $getProviderId, 'Set or Get failed.');
    }

    /**
     * testGetResources
     *
     * @covers \RcmUser\Provider\RcmUserAclResourceProvider::getResources
     *
     * @return void
     */
    public function testGetResources()
    {
        $this->buildRcmUserAclResourceProvider();

        $resources = $this->rcmUserAclResourceProvider->getResources();

        $this->assertTrue(is_array($resources), 'Array of resources not returned.');
    }

    /**
     * testGetResource
     *
     * @covers \RcmUser\Provider\RcmUserAclResourceProvider::getResource
     *
     * @return void
     */
    public function testGetResource()
    {
        $this->buildRcmUserAclResourceProvider();

        $resource = $this->rcmUserAclResourceProvider->getResource('rcmuser');

        $this->assertTrue(($resource instanceof AclResource), 'AclResource not returned.');
    }
}
 