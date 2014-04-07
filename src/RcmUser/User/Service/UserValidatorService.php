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
use RcmUser\User\InputFilter\UserInputFilter;
use RcmUser\User\Result;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

class UserValidatorService implements UserValidatorServiceInterface
{
    protected $userInputFilterConfig;

    protected $userInputFilter;

    protected $userInputFilterFactory;

    /**
     * @param mixed $userInputFilterConfig
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

    /**
     * @param mixed $userInputFilter
     */
    public function setUserInputFilter(InputFilter $userInputFilter)
    {
        $this->userInputFilter = $userInputFilter;
    }

    /**
     * @return mixed
     */
    public function getUserInputFilter()
    {
        return $this->userInputFilter;
    }

    /**
     * @param mixed $userInputFilterFactory
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
     * @param $user
     *
     * @return Result
     */
    public function validateUser(User $user)
    {

        // @todo inject this
        $inputFilter = $this->getUserInputFilter();
        $factory = $this->getUserInputFilterFactory();
        $inputs = $this->getUserInputFilterConfig();//$serviceLocator->get('RcmUser\UserConfig')->get('InputFilter', array());

        // only check values if they are not null
        // (null values are ignored so we may use the same object for validations and data values);
        // null basically means unchanged or no updated value in this case,
        if($user->getUsername() !== null && isset($inputs['username'])){

            $inputFilter->add($factory->createInput($inputs['username']), 'username');
        }
        if($user->getPassword() !== null && isset($inputs['password'])){

            $inputFilter->add($factory->createInput($inputs['password']), 'password');
        }

        $inputFilter->setData($user);

        if ($inputFilter->isValid()) {

            $user->populate($inputFilter->getValues());

            return new Result($user);
        } else {

            $result = new Result($user, Result::CODE_FAIL, 'User input not valid');

            foreach ($inputFilter->getInvalidInput() as $key => $error) {

                $result->setMessage($key, $error->getMessages());
            }

            return $result;
        }
    }
} 