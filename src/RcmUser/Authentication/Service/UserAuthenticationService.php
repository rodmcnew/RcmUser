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
use Zend\Authentication\Result;

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
        /* + LOW_LEVEL_PREP */
        if (!$user->isEnabled()) {
            return new Result(
                Result::FAILURE_UNCATEGORIZED,
                $user,
                array('User is disabled.')
            );
        }
        /* - LOW_LEVEL_PREP */

        /* @event validateCredentials
         * - expects listener to return
         * Zend\Authentication\Result with
         * Result->identity == to user object ($user)
         */
        $results = $this->getEventManager()->trigger(
            'validateCredentials', $this, array('user' => $user),
            function ($result) {
                return $result->isValid();
            }
        );

        $result = $results->last();

        if ($result === null) {
            throw new \Exception(
                'No auth listener registered or no results returned.'
            );
        }

        if ($results->stopped()) {

            /*
             * @event validateCredentialsSuccess
             */
            $this->getEventManager()->trigger(
                'validateCredentialsSuccess',
                $this,
                array('result' => $result)
            );

            return $result;
        }

        /*
         * @event validateCredentialsFail
         */
        $this->getEventManager()->trigger(
            'validateCredentialsFail',
            $this,
            array('result' => $result)
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
        /* + LOW_LEVEL_PREP */
        if (!$user->isEnabled()) {
            return new Result(
                Result::FAILURE_UNCATEGORIZED,
                $user,
                array('User is disabled.')
            );
        }
        /* - LOW_LEVEL_PREP */

        /* @event authenticate
         * - expects listener to return
         * Zend\Authentication\Result with
         * Result->identity == to user object ($user)
         */
        $results = $this->getEventManager()->trigger(
            'authenticate', $this, array('user' => $user),
            function ($result) {
                return $result->isValid();
            }
        );

        $result = $results->last();

        if ($result === null) {
            throw new \Exception(
                'No auth listener registered or no results returned.'
            );
        }

        if ($results->stopped()) {

            /*
             * @event authenticateSuccess
             */
            $this->getEventManager()->trigger(
                'authenticateSuccess',
                $this,
                array('result' => $result)
            );

            return $result;
        }

        /*
         * @event authenticateFail
         */
        $this->getEventManager()->trigger(
            'authenticateFail',
            $this,
            array('result' => $result)
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
        /*
         * @event clearIdentity
         */
        $this->getEventManager()->trigger(
            'clearIdentity',
            $this,
            array()
        );

        return true;
    }

    /**
     * getIdentity
     *
     * @param null $deflt default is no identity
     *
     * @return mixed|null
     */
    public function getIdentity($deflt = null)
    {
        /*
         * @event getIdentity
         */
        $results = $this->getEventManager()->trigger(
            'getIdentity',
            $this,
            array()
        );

        $user = $results->last();

        if(empty($user)){

            return $deflt;
        }

        return $user;
    }
}