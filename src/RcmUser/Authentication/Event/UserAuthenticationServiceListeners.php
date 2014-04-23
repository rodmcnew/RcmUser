<?php
/**
 * UserAuthenticationServiceListeners.php
 *
 * UserAuthenticationServiceListeners
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


use RcmUser\Event\AbstractListener;
use Zend\Authentication\Result;

/**
 * UserAuthenticationServiceListeners
 *
 * UserAuthenticationServiceListeners
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
class UserAuthenticationServiceListeners extends AbstractAuthServiceListeners
{
    /**
     * @var string
     */
    protected $id = 'RcmUser\Authentication\Service\UserAuthenticationService';

    /**
     * @var int
     */
    protected $priority = 1;

    /**
     * @var array
     */
    protected $listenerMethods
        = array(
            'onValidateCredentials' => 'validateCredentials',
            //'onValidateCredentialsSuccess' => 'validateCredentialsSuccess',
            //'onValidateCredentialsFail' => 'validateCredentialsFail',

            'onAuthenticate' => 'authenticate',
            //'onAuthenticateSuccess' => 'authenticateSuccess',
            //'onAuthenticateFail' => 'authenticateFail',

            'onClearIdentity' => 'clearIdentity',
            'onGetIdentity' => 'getIdentity',
        );


    public function onValidateCredentials($e)
    {
        $user = $e->getParam('user');

        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $result = $adapter->authenticate();

        return $result;
    }

    public function onAuthenticate($e)
    {
        $user = $e->getParam('user');

        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $result = $this->getAuthService()->authenticate($adapter);

        return $result;
    }

    public function onClearIdentity($e)
    {
        $authService = $this->getAuthService();

        if ($authService->hasIdentity()) {

            $authService->clearIdentity();
        }

        return true;
    }

    public function onGetIdentity($e)
    {
        $user = $e->getParam('user');

        $authService = $this->getAuthService();

        $currentUser = $authService->getIdentity();

        if (!empty($currentUser)) {

            $user->populate($currentUser);
        }

        return $user;
    }
} 