<?php
/**
 * ConfigTest.php
 *
 * TEST
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Config
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Config;

use RcmUser\Config\Config;
use RcmUser\Test\Zf2TestCase;

require_once __DIR__ . '/../../Zf2TestCase.php';

/**
 * Class ConfigTest
 *
 * TEST
 *
 * PHP version 5
 *
 * @covers \RcmUser\Config\Config
 */
class ConfigTest extends Zf2TestCase
{

    public function testGet()
    {
        $configArr = array('some' => 'thing');

        $config = new Config($configArr);

        $default = 'nope';

        $val1 = $config->get('some', $default);
        $val2 = $config->get('nothing', $default);

        $this->assertEquals('thing', $val1, 'Value not returned');
        $this->assertEquals($default, $val2, 'Default value not returned');
    }
}
 