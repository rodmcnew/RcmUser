<?php
/**
 * UserTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUserTest\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUserTest\User\Entity;

require_once __DIR__ . '/../../../../../Rcm/test/Base/ZF2TestCase.php';

use RcmTest\Base\Zf2TestCase;
use RcmUser\User\Entity\User;


class UserTest extends Zf2TestCase //\PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->addModule('RcmUser');
        parent::setUp();
        //$this->instanceConfig = new DoctrineJsonInstanceConfig();
    }

    protected function getNewUser($prefix = 'A')
    {
        $user = new User();
        $user->setId($prefix . '_id');
        $user->setUsername($prefix . '_username');
        $user->setPassword($prefix . '_password');
        $user->setState($prefix . '_state');
        $user->setProperties(array('property1', $prefix . '_property1'));
        $user->setProperty('property2', $prefix . '_property2');

        return $user;
    }

    public function testArrayIterator()
    {
        $userA = $this->getNewUser('A');
        $userArr = iterator_to_array($userA);

        $this->assertTrue(is_array($userArr), 'Iterator failed work.');

        $this->assertArrayHasKey(
            'id', $userArr, 'Iterator did not populate correctly.'
        );
    }

    public function testPopulate()
    {
        $userA = $this->getNewUser('A');
        $userB = $this->getNewUser('B');

        $userC = $this->getNewUser('C');
        $userArrC = iterator_to_array($userC);
        $userD = 'Some wrong user format';

        $userA->populate($userB);

        $this->assertEquals($userA, $userB, 'Populate from object not successful');

        $userA->populate($userArrC);

        $this->assertEquals($userA, $userC, 'Populate from array not successful');

    }

    public function testMerge()
    {
        $userA = new User();
        $userB = $this->getNewUser('A');
        $userC = $this->getNewUser('C');

        $userA->merge($userB);

        $this->assertEquals($userA, $userB, 'Merge to empty object not successful');

        $userA->merge($userC);

        $this->assertNotEquals($userA, $userC, 'Merge to populated object not successful');

        $userA->setId(null);

        $userA->merge($userC);

        $this->assertNotEquals($userA, $userC, 'Merge to populated single property not successful');
        $this->assertEquals($userA->getId(), $userC->getId(), 'Merge to single property not successful');
    }

    public function testJsonSerialize()
    {
        $userA = $this->getNewUser('A');

        $userAjson = json_encode($userA);
        //var_dump($userAjson);
        $this->assertJson($userAjson, 'User not converted to JSON.');
    }
}
 