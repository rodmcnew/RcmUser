<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Event;


use RcmUser\Event\AbstractListener;
use RcmUser\User\Data\UserDataPreparerInterface;
use RcmUser\User\Data\UserValidatorInterface;

class AbstractUserValidatorListener extends AbstractListener  {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\User\Service\UserDataService';
    protected $event = 'userValidation';
    protected $priority = 5;


    /**
     * @var UserValidatorInterface
     */
    protected $userValidator;

    /**
     * @param UserValidatorInterface $UserValidator
     */
    public function setUserValidator(UserValidatorInterface $userValidator)
    {
        $this->userValidator = $userValidator;
    }

    /**
     * @return UserValidatorInterface
     */
    public function getUserValidator()
    {
        return $this->userValidator;
    }
} 