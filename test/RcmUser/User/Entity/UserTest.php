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

namespace RcmUser\Test\User\Entity;

require_once __DIR__ . '/../../ZF2TestCase.php';

use RcmUser\User\Entity\User;


class UserTest extends \RcmUser\Zf2TestCase //\PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
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

    public function testSetGet()
    {
        $user = new User();

        $value = 'id123';
        $user->setId($value);
        $this->assertEquals($value, $user->getId(), 'Setter or getter failed.');

        $value = 'usernamexxx';
        $user->setUsername($value);
        $this->assertEquals($value, $user->getUsername(), 'Setter or getter failed.');

        $value = 'passwordxxx';
        $user->setPassword($value);
        $this->assertEquals($value, $user->getPassword(), 'Setter or getter failed.');

        $value = 'statexxx';
        $user->setState($value);
        $this->assertEquals($value, $user->getState(), 'Setter or getter failed.');

        $pvalue = array('Y' => 'propertyYYY');
        $value = 'propertyXXX';
        $user->setProperties($pvalue);
        $this->assertArrayHasKey('Y', $user->getProperties(), 'Setter or getter failed.');
        $user->setProperty('X', $value);
        $this->assertEquals($value, $user->getProperty('X'), 'Setter or getter failed.');
        $this->assertArrayHasKey('Y', $user->getProperties(), 'Setter or getter failed.');
    }

    public function testIsEnabled(){

        $user = new User();
        $user->setState(User::STATE_DISABLED);

        $this->assertFalse($user->isEnabled(), 'State check failed.');
    }

    public function testArrayIterator()
    {
        $userA = $this->getNewUser('A');
        $iter = $userA->getIterator();
        $userArr = iterator_to_array($userA);
        $userArr2 = iterator_to_array($iter);

        $this->assertTrue($userArr == $userArr2, 'Iterator failed work.');

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
        //$userD = 'Some wrong user format';

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
 