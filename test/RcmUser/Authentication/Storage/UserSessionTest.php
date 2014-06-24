<?php
 /**
 * UserSessionTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Authentication\Storage
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Authentication\Storage;

require_once __DIR__ . '/../../../Zf2TestCase.php';

use RcmUser\Authentication\Storage\UserSession;

class UserSessionTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $sess = new UserSession();
    }
}
 