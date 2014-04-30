<?php
/**
 * ReadOnlyUserTest.php
 *
 * TEST
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\User\Entity;

use RcmUser\User\Entity\ReadOnlyUser;
use RcmUser\User\Entity\User;
use RcmUser\Zf2TestCase;

require_once __DIR__ . '/../../../Zf2TestCase.php';

class ReadOnlyUserTest extends Zf2TestCase
{

    /**
     * buildReadOnlyUser
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::
     *
     * @return ReadOnlyUser
     */
    public function buildReadOnlyUser()
    {
        $user = new User();
        $user->setId('id');
        $user->setUsername('username');
        $user->setPassword('password');
        $user->setProperties(array('A'=>'something'));

        return new ReadOnlyUser($user);
    }

    /**
     * testConstruct
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::__construct
     * @covers RcmUser\User\Entity\ReadOnlyUser::populate
     *
     * @return void
     */
    public function testConstruct()
    {
        $user = new User();
        $user->setId('id');
        $user->setUsername('username');
        $user->setPassword('password');
        $user->setProperties(array('A'=>'something'));

        return new ReadOnlyUser($user);
    }

    /**
     * testSetId
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::setID
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testSetId()
    {
        $roUser = $this->buildReadOnlyUser();
        $roUser->setId('234');
    }

    /**
     * testSetUsername
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::setUsername
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testSetUsername()
    {
        $roUser = $this->buildReadOnlyUser();
        $roUser->setUsername('234');
    }

    /**
     * testSetPassword
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::setPassword
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testSetPassword()
    {
        $roUser = $this->buildReadOnlyUser();
        $roUser->setPassword('234');
    }

    /**
     * testSetState
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::setState
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testSetState()
    {
        $roUser = $this->buildReadOnlyUser();
        $roUser->setState('234');
    }

    /**
     * testSetProperties
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::setProperties
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testSetProperties()
    {
        $roUser = $this->buildReadOnlyUser();
        $roUser->setProperties(array('B' => '234'));
    }

    /**
     * testSetProperty
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::setProperty
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testSetProperty()
    {
        $roUser = $this->buildReadOnlyUser();
        $roUser->setProperty('B', '234');
    }

    /**
     * testPopulate
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::populate
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testPopulate()
    {
        $user = new User('4343');
        $roUser = $this->buildReadOnlyUser();
        $roUser->populate($user);
    }

    /**
     * testPopulate
     *
     * @covers RcmUser\User\Entity\ReadOnlyUser::merge
     * @expectedException \RcmUser\Exception\RcmUserReadOnlyException
     *
     * @return void
     */
    public function testMerge()
    {
        $user = new User('4343');
        $roUser = $this->buildReadOnlyUser();
        $roUser->merge($user);
    }
}
 