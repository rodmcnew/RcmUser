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

use RcmUser\Provider\RcmUserAclResourceProvider;
use RcmUser\Zf2TestCase;

require_once __DIR__ . '/../../Zf2TestCase.php';

class RcmUserAclResourceProviderTest extends Zf2TestCase
{

    public $rcmUserAclResourceProvider;

    public function getRcmUserAclResourceProvider()
    {
        $this->rcmUserAclResourceProvider = new RcmUserAclResourceProvider();

        return $this->rcmUserAclResourceProvider;
    }

    /**
     * testGetAll
     *
     * @covers RcmUser\Provider\RcmUserAclResourceProvider::getAll
     *
     * @return void
     */
    public function testGetAll()
    {
        $resources = $this->getRcmUserAclResourceProvider()->getAll();

        $this->assertTrue(is_array($resources), 'Array of resources not returned.');
    }

    /**
     * testGetAvailableAtRuntime
     *
     * @covers RcmUser\Provider\RcmUserAclResourceProvider::getAvailableAtRuntime
     *
     * @return void
     */
    public function testGetAvailableAtRuntime()
    {
        $resources = $this->getRcmUserAclResourceProvider()->getAvailableAtRuntime();

        $this->assertTrue(is_array($resources), 'Array of resources not returned.');
    }
}
 