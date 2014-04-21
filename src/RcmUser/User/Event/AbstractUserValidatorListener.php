<?php
/**
 * AbstractUserValidatorListener.php
 *
 * AbstractUserValidatorListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Event;


use RcmUser\Event\AbstractListener;
use RcmUser\User\Data\UserValidatorInterface;

/**
 * Class AbstractUserValidatorListener
 *
 * AbstractUserValidatorListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractUserValidatorListener extends AbstractListener
{

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
     * setUserValidator
     *
     * @param UserValidatorInterface $userValidator userValidator
     *
     * @return void
     */
    public function setUserValidator(UserValidatorInterface $userValidator)
    {
        $this->userValidator = $userValidator;
    }

    /**
     * getUserValidator
     *
     * @return UserValidatorInterface
     */
    public function getUserValidator()
    {
        return $this->userValidator;
    }
} 