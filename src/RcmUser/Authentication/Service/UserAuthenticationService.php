<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Authentication\Service;


use RcmUser\Event\EventProvider;
use RcmUser\User\Entity\User;


/**
 * AUTHENTICATION and events
 * Class UserAuthenticationService
 *
 * @package RcmUser\Service
 */
class UserAuthenticationService extends EventProvider
{

    /**
     * @var
     */
    protected $authService;

    /**
     * @param mixed $authService
     */
    public function setAuthService(\Zend\Authentication\AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return mixed
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function validateCredentials(User $user)
    {

        // @event pre - expects listener to return Zend\Authentication\Result with Result->identity == to user object ($user)
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user), function($result){ return $result->isValid();});

        if ($resultsPre->stopped()) {
            // Auth success
            return $resultsPre->last();
        }

        // @todo Inject this as event
        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $result = $adapter->authenticate();

        // @event post - expects Listener to check for $result->isValid() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function authenticate(User $user)
    {

        // @event pre - expects listener to return Zend\Authentication\Result with Result->identity == to user object ($user)
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user), function($result){ return $result->isValid();});

        if ($resultsPre->stopped()) {
            // Auth success
            return $resultsPre->last();
        }

        // @todo Inject this as event
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $result =  $this->getAuthService()->authenticate($adapter);

        // @event post - expects Listener to check for $result->isValid() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    public function clearIdentity()
    {

        $authService = $this->getAuthService();

        if ($authService->hasIdentity()) {

            $currentUser = $this->getIdentity();

            // @event
            $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));

            $authService->clearIdentity();
        }
    }

    public function getIdentity()
    {
        $authService = $this->getAuthService();

        $currentUser = $authService->getIdentity();

        // @event
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));

        return $currentUser;
    }
}