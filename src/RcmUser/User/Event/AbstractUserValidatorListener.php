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
use RcmUser\User\Service\UserDataPrepServiceInterface;
use RcmUser\User\Service\UserValidatorServiceInterface;

class AbstractUserValidatorListener extends AbstractListener  {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\User\Service\UserDataService';
    protected $event = 'userValidation';
    protected $priority = 5;


    /**
     * @var UserValidatorServiceInterface
     */
    protected $userValidatorService;

    /**
     * @param UserValidatorServiceInterface $userValidatorService
     */
    public function setUserValidatorService(UserValidatorServiceInterface $userValidatorService)
    {
        $this->userValidatorService = $userValidatorService;
    }

    /**
     * @return UserValidatorServiceInterface
     */
    public function getUserValidatorService()
    {
        return $this->userValidatorService;
    }
} 