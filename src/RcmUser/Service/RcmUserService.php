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

use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use RcmUser\User\Service\UserDataService;
use RcmUser\User\Service\UserPropertyService;
use ZfcBase\EventManager\EventProvider;

//use ZfcUser\Service\User;

/**
 * Class RcmUserService
 *
 * @package RcmUser\Service
 */
class RcmUserService extends \RcmUser\Event\EventProvider
{

    /**
     * @var UserDataService
     */
    protected $userDataService;

    /**
     * @var
     */
    protected $userPropertyService;

    /**
     * @var
     */
    protected $userAuthService;

    /**
     * @param UserDataService $userDataService
     */
    public function setUserDataService(UserDataService $userDataService)
    {
        $this->userDataService = $userDataService;
    }

    /**
     * @return mixed
     */
    public function getUserDataService()
    {
        return $this->userDataService;
    }

    /**
     * @param mixed $userPropertyService
     */
    public function setUserPropertyService(UserPropertyService $userPropertyService)
    {
        $this->userPropertyService = $userPropertyService;
    }

    /**
     * @return mixed
     */
    public function getUserPropertyService()
    {
        return $this->userPropertyService;
    }

    /**
     * @param mixed $userAuthService
     */
    public function setUserAuthService(UserAuthenticationService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    /**
     * @return mixed
     */
    public function getUserAuthService()
    {
        return $this->userAuthService;
    }

    /** HELPERS ***************************************/

    /**
     * @param User $user
     *
     * @return null
     */
    public function getRegisteredUser(User $user)
    {
        $result = $this->readUser($user);

        if ($result->isSuccess()) {

            return $result->getUser();
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getSessUser()
    {

        $user = $this->getIdentity();

        return $user;
    }

    /**
     * @return User
     */
    public function getNewUser()
    {
        return $this->buildNewUser();
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isRegistered(User $user)
    {
        return $this->userExists($user);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function userExists(User $user)
    {
        $result = $this->readUser($user);

        return $result->isSuccess();
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isSessUser(User $user)
    {
        $sessUser = $this->getSessUser();

        if (empty($sessUser)) {

            return false;
        }

        // @todo make sure this is a valid check for all cases
        if ($user->getId() === $sessUser->getId() || $user->getUsername() === $sessUser->getUsername()) {

            return true;
        }

        return false;
    }

    /* CRUD HELPERS ***********************************/

    public function readUser(User $user)
    {
        return $this->getUserDataService()->readUser($user);
    }

    public function createUser(User $user)
    {
        return $this->getUserDataService()->createUser($user);
    }

    public function updateUser(User $user)
    {
        return $this->getUserDataService()->updateUser($user);
    }

    public function deleteUser(User $user)
    {
        return $this->getUserDataService()->deleteUser($user);
    }

    /* PROPERTY HELPERS *******************************/

    /**
     * @param User $user
     * @param string $propertyNameSpace
     * @param mixed $dflt default
     * @param bool $refresh
     *
     * @return mixed
     */
    public function getUserProperty(User $user, $propertyNameSpace, $dflt = null, $refresh = false)
    {
        return $this->getUserPropertyService()->getUserProperty($user, $propertyNameSpace, $dflt, $refresh);
    }

    /**
     * @param string $propertyNameSpace
     * @param mixed $dflt default
     * @param bool $refresh
     *
     * @return mixed|null
     */
    public function getCurrentUserProperty($propertyNameSpace, $dflt = null, $refresh = false)
    {
        $user = $this->getSessUser();

        if (empty($user)) {

            return $dflt;
        }

        return $this->getUserProperty($user, $propertyNameSpace, $dflt, $refresh);

    }

    /**
     * @param User $user
     */
    public function disableUser(User $user)
    {

        // @todo write me
    }

    /* AUTHENTICATION HELPERS ********************************/

    /**
     * @param User $user
     *
     * @return Result
     */
    public function logIn(User $user)
    {

        return $this->authenticate($user);
    }

    public function logOut()
    {

        return $this->clearIdentity();
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function validateCredentials(User $user)
    {

        return $this->getUserAuthService()->validateCredentials($user);
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function authenticate(User $user)
    {

        return $this->getUserAuthService()->authenticate($user);
    }

    /**
     * @return void
     */
    public function clearIdentity()
    {
        return $this->getUserAuthService()->clearIdentity();
    }

    /**
     * @return void
     */
    public function getIdentity()
    {

        return $this->getUserAuthService()->getIdentity();
    }

    /* UTILITIES **************************************/
    /**
     * @return User
     */
    public function buildNewUser()
    {

        $user = new User();

        return $user;
    }
}