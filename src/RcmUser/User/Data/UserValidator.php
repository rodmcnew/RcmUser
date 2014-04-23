<?php
/**
 * UserValidator.php
 *
 * UserValidator
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Data;


use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

/**
 * Class UserValidator
 *
 * UserValidator
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserValidator implements UserValidatorInterface
{
    /**
     * @var array $userInputFilterConfig
     */
    protected $userInputFilterConfig;

    /**
     * @var string $userInputFilterClass
     */
    protected $userInputFilterClass = 'Zend\InputFilter\InputFilter\InputFilter';

    /**
     * @var Factory $userInputFilterFactory
     */
    protected $userInputFilterFactory;

    /**
     * setUserInputFilterConfig
     *
     * @param array $userInputFilterConfig userInputFilterConfig from module.config
     *
     * @return void
     */
    public function setUserInputFilterConfig($userInputFilterConfig)
    {
        $this->userInputFilterConfig = $userInputFilterConfig;
    }

    /**
     * getUserInputFilterConfig
     *
     * @return array
     */
    public function getUserInputFilterConfig()
    {
        return $this->userInputFilterConfig;
    }

    /**
     * setUserInputFilterClass
     *
     * @param string $userInputFilterClass userInputFilterClass
     *
     * @return void
     */
    public function setUserInputFilterClass(
        $userInputFilterClass = 'Zend\InputFilter\InputFilter'
    ) {
        $this->userInputFilterClass = $userInputFilterClass;
    }

    /**
     * getUserInputFilterClass
     *
     * @return string
     */
    public function getUserInputFilterClass()
    {
        // @todo throw error if not defined
        return $this->userInputFilterClass;
    }

    /**
     * getUserInputFilter
     *
     * @return \Zend\InputFilter\InputFilterInterface
     */
    public function getUserInputFilter()
    {

        $class = $this->getUserInputFilterClass();

        return new $class();
    }

    /**
     * setUserInputFilterFactory
     *
     * @param Factory $userInputFilterFactory userInputFilterFactory
     *
     * @return void
     */
    public function setUserInputFilterFactory(Factory $userInputFilterFactory)
    {
        $this->userInputFilterFactory = $userInputFilterFactory;
    }

    /**
     * getUserInputFilterFactory
     *
     * @return Factory
     */
    public function getUserInputFilterFactory()
    {
        return $this->userInputFilterFactory;
    }


    /**
     * validateUpdateUser
     *
     * @param User $updatedUser   updatedUser
     * @param User $updatableUser updatableUser
     * @param User $existingUser  existingUser
     *
     * @return Result
     */
    public function validateUpdateUser(User $updatedUser, User $updatableUser, User $existingUser)
    {
        $inputFilter = $this->getUserInputFilter();
        $factory = $this->getUserInputFilterFactory();

        $inputs = $this->getUserInputFilterConfig();

        if ($updatedUser->getUsername() !== $existingUser->getUsername() && isset($inputs['username'])) {

            $inputFilter->add(
                $factory->createInput($inputs['username']), 'username'
            );
        }

        if ($updatedUser->getPassword() !== $existingUser->getPassword() && isset($inputs['password'])) {

            $inputFilter->add(
                $factory->createInput($inputs['password']), 'password'
            );
        }

        return $this->validateUser($updatableUser, $inputFilter);
    }

    /**
     * validateCreateUser
     *
     * @param User $updatedUser   updatedUser
     * @param User $updatableUser updatableUser
     *
     * @return Result
     */
    public function validateCreateUser(User $updatedUser, User $updatableUser)
    {
        $inputFilter = $this->getUserInputFilter();
        $factory = $this->getUserInputFilterFactory();

        $inputs = $this->getUserInputFilterConfig();

        $inputFilter->add($factory->createInput($inputs['username']), 'username');

        $inputFilter->add($factory->createInput($inputs['password']), 'password');

        return $this->validateUser($updatableUser, $inputFilter);

    }

    /**
     * validateUser
     *
     * @param User        $changeableUser changeableUser
     * @param InputFilter $inputFilter    inputFilter
     *
     * @return Result
     */
    public function validateUser(User $changeableUser, InputFilter $inputFilter)
    {

        $inputFilter->setData($changeableUser);

        if ($inputFilter->isValid()) {

            $changeableUser->populate($inputFilter->getValues());

            return new Result($changeableUser);
        } else {

            $result = new Result(
                $changeableUser,
                Result::CODE_FAIL,
                'User input not valid'
            );

            foreach ($inputFilter->getInvalidInput() as $key => $error) {

                $result->setMessage($key, $error->getMessages());
            }

            return $result;
        }
    }
} 