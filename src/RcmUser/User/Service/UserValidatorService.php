<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Service;


use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

class UserValidatorService implements UserValidatorServiceInterface
{
    protected $userInputFilterConfig;

    protected $userInputFilterClass = 'Zend\InputFilter\InputFilter\InputFilter';

    protected $userInputFilterFactory;

    /**
     * @param array $userInputFilterConfig
     */
    public function setUserInputFilterConfig($userInputFilterConfig)
    {
        $this->userInputFilterConfig = $userInputFilterConfig;
    }

    /**
     * @return mixed
     */
    public function getUserInputFilterConfig()
    {
        return $this->userInputFilterConfig;
    }

    public function setUserInputFilterClass($userInputFilterClass = 'Zend\InputFilter\InputFilter\InputFilter')
    {
        $this->userInputFilterClass = $userInputFilterClass;
    }

    /**
     * @return string
     */
    public function getUserInputFilterClass()
    {
        // @todo throw error if not defined
        return $this->userInputFilterClass;
    }

    /**
     * @return mixed
     */
    public function getUserInputFilter()
    {

        $class = $this->getUserInputFilterClass();

        return new $class();
    }

    /**
     * @param Factory $userInputFilterFactory
     */
    public function setUserInputFilterFactory(Factory $userInputFilterFactory)
    {
        $this->userInputFilterFactory = $userInputFilterFactory;
    }

    /**
     * @return mixed
     */
    public function getUserInputFilterFactory()
    {
        return $this->userInputFilterFactory;
    }


    /**
     * @param User $updatedUser
     * @param User $updatableUser
     *
     * @return Result
     */
    public function validateUpdateUser(User $updatedUser, User $updatableUser)
    {
        $inputFilter = $this->getUserInputFilter();
        $factory = $this->getUserInputFilterFactory();

        $inputs = $this->getUserInputFilterConfig();

        // only check values if they are not null
        // (null values are ignored so we may use the same object for validations and data values);
        // null basically means unchanged or no updated value in this case,
        if ($updatedUser->getUsername() !== null && isset($inputs['username'])) {

            $inputFilter->add($factory->createInput($inputs['username']), 'username');
        }
        if ($updatedUser->getPassword() !== null && isset($inputs['password'])) {

            $inputFilter->add($factory->createInput($inputs['password']), 'password');
        }

        return $this->validateUser($updatableUser, $inputFilter);

    }

    public function validateCreateUser(User $updatedUser, User $updatableUser)
    {
        $inputFilter = $this->getUserInputFilter();
        $factory = $this->getUserInputFilterFactory();

        $inputs = $this->getUserInputFilterConfig();

        $inputFilter->add($factory->createInput($inputs['username']), 'username');

        $inputFilter->add($factory->createInput($inputs['password']), 'password');

        return $this->validateUser($updatableUser, $inputFilter);

    }

    public function validateUser(User $changeableUser, InputFilter $inputFilter)
    {

        $inputFilter->setData($changeableUser);

        if ($inputFilter->isValid()) {

            $changeableUser->populate($inputFilter->getValues());

            return new Result($changeableUser);
        } else {

            $result = new Result($changeableUser, Result::CODE_FAIL, 'User input not valid');

            foreach ($inputFilter->getInvalidInput() as $key => $error) {

                $result->setMessage($key, $error->getMessages());
            }

            return $result;
        }
    }
} 