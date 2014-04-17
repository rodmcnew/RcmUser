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
 * AUTHENTICATION events which trigger the listeners which do the actual work
 * Class UserAuthenticationService
 *
 * @package RcmUser\Service
 */
class UserAuthenticationService extends EventProvider
{

    /**
     * @param User $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function validateCredentials(User $user)
    {

        // @event pre - expects listener to return Zend\Authentication\Result with Result->identity == to user object ($user)
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user), function($result){ return $result->isValid();});

        $result = $resultsPre->last();

        if($result === null){
            throw new \Exception('No auth listener registered or no results returned.');
        }

        if ($resultsPre->stopped()) {
            // Auth success
            return $result;
        }

        // @event post - expects Listener to check for $result->isValid() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function authenticate(User $user)
    {

        // @event pre - expects listener to return Zend\Authentication\Result with Result->identity == to user object ($user)
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user), function($result){ return $result->isValid();});

        $result = $resultsPre->last();

        if($result === null){
            throw new \Exception('No auth listener registered or no results returned.');
        }

        if ($resultsPre->stopped()) {
            // Auth success
            return $result;
        }

        // @event post - expects Listener to check for $result->isValid() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     *
     */
    public function clearIdentity()
    {
        // @event
        $this->getEventManager()->trigger(__FUNCTION__, $this, array());
    }

    /**
     * @return User
     */
    public function getIdentity()
    {
        $currentUser = new User();

        // @event
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));

        return $currentUser;
    }
}