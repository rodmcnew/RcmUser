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


use RcmUser\User\Entity\AbstractUser;
use RcmUser\User\Result;
use Zend\InputFilter\InputFilter;

class UserValidatorService
{

    /**
     * @var InputFilter
     */
    protected $userInputFilter;

    public function __construct(InputFilter $userInputFilter){

        $this->setUserInputFilter($userInputFilter);
    }

    /**
     * @param \Zend\InputFilter\InputFilter $userInputFilter
     */
    public function setUserInputFilter(InputFilter $userInputFilter)
    {
        $this->userInputFilter = $userInputFilter;
    }

    /**
     * @return \Zend\InputFilter\InputFilter
     */
    public function getUserInputFilter()
    {
        return $this->userInputFilter;
    }

    /**
     * @param $user
     *
     * @return Result
     */
    public function validateUser(AbstractUser $user)
    {

        $inputFilter = $this->getUserInputFilter();

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