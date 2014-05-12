<?php
/**
 * AbstractAuthServiceListeners.php
 *
 * AbstractAuthServiceListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Authentication\Event;


use RcmUser\Authentication\Service\AuthenticationService;
use Zend\Authentication\Result;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * AbstractAuthServiceListeners
 *
 * AbstractAuthServiceListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractAuthServiceListeners implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    /**
     * @var string
     */
    protected $id = 'RcmUser\Authentication\Service\UserAuthenticationService';

    /**
     * @var int
     */
    protected $priority = 1;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var array
     */
    protected $listenerMethods
        = array(
            'onValidateCredentials' => 'validateCredentials',
            'onValidateCredentialsSuccess' => 'validateCredentialsSuccess',
            'onValidateCredentialsFail' => 'validateCredentialsFail',

            'onAuthenticate' => 'authenticate',
            'onAuthenticateSuccess' => 'authenticateSuccess',
            'onAuthenticateFail' => 'authenticateFail',

            'onClearIdentity' => 'clearIdentity',
            'onHasIdentity' => 'hasIdentity',
            'onSetIdentity' => 'setIdentity',
            'onGetIdentity' => 'getIdentity',
        );

    /**
     * setAuthService
     *
     * @param AuthenticationService $authService authService
     *
     * @return void
     */
    public function setAuthService(
        AuthenticationService $authService
    ) {
        $this->authService = $authService;
    }

    /**
     * getAuthService
     *
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

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
     * onValidateCredentials
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onValidateCredentials($e)
    {
        return new Result(
            null,
            Result::FAILURE_UNCATEGORIZED,
            'Listener (' . __METHOD__ . ') not defined.'
        );
    }

    /**
     * onValidateCredentialsSuccess
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onValidateCredentialsSuccess($e)
    {
        return new Result(
            null,
            Result::FAILURE_UNCATEGORIZED,
            'Listener (' . __METHOD__ . ') not defined.'
        );
    }

    /**
     * onValidateCredentialsFail
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onValidateCredentialsFail($e)
    {
        return new Result(
            null,
            Result::FAILURE_UNCATEGORIZED,
            'Listener (' . __METHOD__ . ') not defined.'
        );
    }

    /**
     * onAuthenticate
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onAuthenticate($e)
    {
        return new Result(
            null,
            Result::FAILURE_UNCATEGORIZED,
            'Listener (' . __METHOD__ . ') not defined.'
        );
    }

    /**
     * onAuthenticateSuccess
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onAuthenticateSuccess($e)
    {
        return new Result(
            null,
            Result::FAILURE_UNCATEGORIZED,
            'Listener (' . __METHOD__ . ') not defined.'
        );
    }

    /**
     * onAuthenticateFail
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onAuthenticateFail($e)
    {
        return new Result(
            null,
            Result::FAILURE_UNCATEGORIZED,
            'Listener (' . __METHOD__ . ') not defined.'
        );
    }

    /**
     * onClearIdentity
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onClearIdentity($e)
    {
        return;
    }

    /**
     * onHasIdentity
     *
     * @param Event $e e
     *
     * @return bool
     */
    public function onHasIdentity($e){

        return false;
    }

    /**
     * onSetIdentity
     *
     * @param Event $e e
     *
     * @return void
     */
    public function onSetIdentity($e){

        return;
    }

    /**
     * onGetIdentity
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onGetIdentity($e)
    {
        return new Result(
            null,
            Result::FAILURE_UNCATEGORIZED,
            'Listener (' . __METHOD__ . ') not defined.'
        );
    }
} 