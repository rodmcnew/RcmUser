<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Service;


use RcmUser\Model\Event\EventProvider;
use RcmUser\Model\User\Entity\User;
use Zend\Authentication\AuthenticationService;


/**
 * AUTHENTICATION and events
 * Class RcmUserAuthenticationService
 *
 * @package RcmUser\Service
 */
class RcmUserAuthenticationService extends EventProvider
{

    /**
     * @var
     */
    protected $authService;

    /**
     * @param mixed $authService
     */
    public function setAuthService(AuthenticationService $authService)
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

        // @event validateCredentials.pre
        $eventResults = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user));

        foreach ($eventResults as $eventResult) {

            if ($eventResult->isValid()) {

                $this->getEventManager()->trigger(__FUNCTION__ . '.success', $this, array('successResult' => $eventResult, 'results' => $eventResults));

                return $eventResult;
            }
        }

        // @todo Inject this as event
        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);

        return $adapter->authenticate();

        // @event validateCredentials.fail
        $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('successResult' => null, 'results' => $eventResults));

        return $eventResults->last();


    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function authenticate(User $user)
    {

        // @event authenticate.pre
        $eventResults = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user));

        foreach ($eventResults as $eventResult) {

            if ($eventResult->isValid()) {

                $this->getEventManager()->trigger(__FUNCTION__ . '.success', $this, array('successResult' => $eventResult, 'results' => $eventResults));

                return $eventResult;
            }
        }

        // @todo Inject this as event
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $authResult = $this->getAuthService()->authenticate($adapter);

        return $authResult;

        // @event authenticate.fail
        $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('successResult' => null, 'results' => $eventResults));

        return $eventResults->last();
    }

    public function clearIdentity()
    {
        $currentUser = $this->getIdentity();

        // @event clearSessUser
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));

        // @todo Inject this as event
        $authService = $this->getAuthService();

        if ($authService->hasIdentity()) {
            $authService->clearIdentity();
        }
    }

    public function getIdentity()
    {

        $authService = $this->getAuthService();

        return $authService->getIdentity();
    }
}