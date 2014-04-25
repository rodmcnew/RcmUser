<?php
/**
 * AbstractUserDataServiceListeners.php
 *
 * AbstractUserDataServiceListeners
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
use RcmUser\User\Result;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Class AbstractUserDataServiceListeners
 *
 * AbstractUserDataServiceListeners
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
class AbstractUserDataServiceListeners implements ListenerAggregateInterface
{

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\User\Service\UserDataService';
    protected $priority = -1;
    protected $listenerMethods
        = array(
            'onBeforeCreateUser' => 'beforeCreateUser',
            'onCreateUser' => 'createUser',
            'onCreateUserFail' => 'createUserFail',
            'onCreateUserSuccess' => 'createUserSuccess',
            
            'onBeforeReadUser' => 'beforeReadUser',
            'onReadUser' => 'readUser',
            'onReadUserFail' => 'readUserFail',
            'onReadUserSuccess' => 'readUserSuccess',
            
            'onBeforeUpdateUser' => 'beforeUpdateUser',
            'onUpdateUser' => 'updateUser',
            'onUpdateUserFail' => 'updateUserFail',
            'onUpdateUserSuccess' => 'updateUserSuccess',
            
            'onBeforeDeleteUser' => 'beforeDeleteUser',
            'onDeleteUser' => 'deleteUser',
            'onDeleteUserFail' => 'deleteUserFail',
            'onDeleteUserSuccess' => 'deleteUserSuccess',
        );


    /**
     * attach
     *
     * @param EventManagerInterface $events events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents = $events->getSharedManager();

        foreach ($this->listenerMethods as $method => $event) {
            $this->listeners[] = $sharedEvents->attach(
                $this->id,
                $event,
                array($this, $method),
                $this->priority
            );
        }
    }

    /**
     * detach
     *
     * @param EventManagerInterface $events events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * onBeforeCreate
     *
     * @param $e
     *
     * @return Result
     */
    public function onBeforeCreateUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onCreate
     *
     * @param $e
     *
     * @return Result
     */
    public function onCreateUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onCreateUserFail
     *
     * @param $e
     *
     * @return Result
     */
    public function onCreateUserFail($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onCreateUserSuccess
     *
     * @param $e
     *
     * @return Result
     */
    public function onCreateUserSuccess($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onBeforeReadUser
     *
     * @param $e
     *
     * @return Result
     */
    public function onBeforeReadUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onReadUser
     *
     * @param $e
     *
     * @return Result
     */
    public function onReadUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onReadUserFail
     *
     * @param $e
     *
     * @return Result
     */
    public function onReadUserFail($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onReadUserSuccess
     *
     * @param $e
     *
     * @return Result
     */
    public function onReadUserSuccess($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onBeforeUpdateUser
     *
     * @param $e
     *
     * @return Result
     */
    public function onBeforeUpdateUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onUpdateUser
     *
     * @param $e
     *
     * @return Result
     */
    public function onUpdateUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onUpdateUserFail
     *
     * @param $e
     *
     * @return Result
     */
    public function onUpdateUserFail($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onUpdateUserSuccess
     *
     * @param $e
     *
     * @return Result
     */
    public function onUpdateUserSuccess($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onBeforeDeleteUser
     *
     * @param $e
     *
     * @return Result
     */
    public function onBeforeDeleteUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onDeleteUser
     *
     * @param $e
     *
     * @return Result
     */
    public function onDeleteUser($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onDeleteUserFail
     *
     * @param $e
     *
     * @return Result
     */
    public function onDeleteUserFail($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }

    /**
     * onDeleteUserSuccess
     *
     * @param $e
     *
     * @return Result
     */
    public function onDeleteUserSuccess($e)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'Listener ('.__METHOD__.') not defined.'
        );
    }
} 