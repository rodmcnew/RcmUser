<?php
/**
 * UserAuthenticationService.php
 *
 * AUTHENTICATION events which trigger the listeners which do the actual work
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Service;
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Authentication\Service;


use RcmUser\Event\EventProvider;
use RcmUser\User\Entity\User;

/**
 * UserAuthenticationService
 *
 * AUTHENTICATION events which trigger the listeners which do the actual work
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserAuthenticationService extends EventProvider
{

    /**
     * validateCredentials
     *
     * @param User $user user
     *
     * @return mixed
     * @throws \Exception
     */
    public function validateCredentials(User $user)
    {

        // @event pre - expects listener to return Zend\Authentication\Result with Result->identity == to user object ($user)
        $resultsPre = $this->getEventManager()->trigger(
            __FUNCTION__ . '.pre', $this, array('user' => $user),
            function ($result) {
                return $result->isValid();
            }
        );

        $result = $resultsPre->last();

        if ($result === null) {
            throw new \Exception('No auth listener registered or no results returned.');
        }

        if ($resultsPre->stopped()) {
            // Auth success
            return $result;
        }

        // @event post - expects Listener to check for $result->isValid() for post actions
        $this->getEventManager()->trigger(
            __FUNCTION__ . '.post', $this, array('result' => $result)
        );

        return $result;
    }

    /**
     * authenticate
     *
     * @param User $user user
     *
     * @return mixed
     * @throws \Exception
     */
    public function authenticate(User $user)
    {

        // @event pre - expects listener to return Zend\Authentication\Result with Result->identity == to user object ($user)
        $resultsPre = $this->getEventManager()->trigger(
            __FUNCTION__ . '.pre', $this, array('user' => $user),
            function ($result) {
                return $result->isValid();
            }
        );

        $result = $resultsPre->last();

        if ($result === null) {
            throw new \Exception('No auth listener registered or no results returned.');
        }

        if ($resultsPre->stopped()) {
            // Auth success
            return $result;
        }

        // @event post - expects Listener to check for $result->isValid() for post actions
        $this->getEventManager()->trigger(
            __FUNCTION__ . '.post', $this, array('result' => $result)
        );

        return $result;
    }

    /**
     * clearIdentity
     *
     * @return void
     */
    public function clearIdentity()
    {
        // @event
        $this->getEventManager()->trigger(__FUNCTION__, $this, array());
    }

    /**
     * getIdentity
     *
     * @return User
     */
    public function getIdentity()
    {
        $currentUser = new User();

        // @event
        $this->getEventManager()->trigger(
            __FUNCTION__, $this, array('user' => $currentUser)
        );

        return $currentUser;
    }
}