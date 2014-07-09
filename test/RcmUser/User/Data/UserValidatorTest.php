<?php
/**
 * UserValidatorTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\User\Data;

require_once __DIR__ . '/../../../Zf2TestCase.php';

use RcmUser\User\Data\UserValidator;
use RcmUser\User\Entity\User;
use RcmUser\User\InputFilter\UserInputFilter;
use Zend\InputFilter\Factory;

/**
 * Class UserValidatorTest
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright ${YEAR} Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 * @covers    \RcmUser\User\Data\UserValidator
 */
class UserValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserValidator $userValidator
     */
    public $userValidator;

    /**
     * setup
     *
     * @return void
     */
    public function setup()
    {
        $this->config = array(

            'username' => array(
                'name' => 'username',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 100,
                        ),
                    ),
                ),
            ),
            'password' => array(
                'name' => 'password',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 100,
                        ),
                    ),
                ),
            ),
        );

        $this->userInputFilter = new UserInputFilter();
        $this->factory = new Factory();

        $this->userValidator = new UserValidator(
            $this->factory,
            $this->userInputFilter,
            $this->config
        );

        $this->requestUser = new User('123');
        $this->requestUser->setUsername('testuser');
        $this->responseUser = new User();
        $this->responseUser->populate($this->requestUser);
        $this->existingUser = new User();
        $this->existingUser->setUsername('newuser');
        $this->existingUser->populate($this->requestUser);
    }

    public function testBuild()
    {
        $this->userValidator = new \RcmUser\User\Data\UserValidator(
            $this->factory,
            $this->userInputFilter,
            $this->config
        );
    }

    public function test()
    {

        $result = $this->userValidator->validateCreateUser(
            $this->requestUser,
            $this->responseUser
        );

        $this->assertInstanceOf(
            '\RcmUser\Result',
            $result
        );

        $this->assertFalse(
            $result->isSuccess(),
            'No password set should return false.'
        );

        $this->assertEquals(
            $this->responseUser,
            $result->getData()
        );

        $result = $this->userValidator->validateUpdateUser(
            $this->requestUser,
            $this->responseUser,
            $this->existingUser
        );

        $this->assertInstanceOf(
            '\RcmUser\Result',
            $result
        );

        $this->assertEquals(
            $this->responseUser,
            $result->getData()
        );

        $this->requestUser->setPassword('NEWNEWNEW');

        $result = $this->userValidator->validateCreateUser(
            $this->requestUser,
            $this->responseUser
        );

        $this->assertInstanceOf(
            '\RcmUser\Result',
            $result
        );

        $this->assertTrue(
            $result->isSuccess(),
            'Password set should return true.'
        );

        $this->assertEquals(
            $this->responseUser,
            $result->getData()
        );


        $this->requestUser->setPassword('NEWNEWNEW');
        $result = $this->userValidator->validateUpdateUser(
            $this->requestUser,
            $this->responseUser,
            $this->existingUser
        );

        $this->assertInstanceOf(
            '\RcmUser\Result',
            $result
        );

        $this->assertEquals(
            $this->responseUser,
            $result->getData()
        );
    }

}
 