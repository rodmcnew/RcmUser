<?php
/**
 * Class RcmUserService
 *
 * RcmUserService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Service;

use RcmUser\Acl\Service\UserAuthorizeService;
use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use RcmUser\User\Service\UserDataService;
use RcmUser\User\Service\UserPropertyService;

//use ZfcUser\Service\User;

/**
 * Class RcmUserService
 *
 * RcmUserService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserService extends \RcmUser\Event\EventProvider
{

    /**
     * @var UserDataService
     */
    protected $userDataService;

    /**
     * @var UserPropertyService
     */
    protected $userPropertyService;

    /**
     * @var UserAuthenticationService
     */
    protected $userAuthService;

    /*
     * ACL
     * @var UserAuthorizeService
     */
    protected $userAuthorizeService;

    /**
     * setUserDataService
     *
     * @param UserDataService $userDataService userDataService
     *
     * @return void
     */
    public function setUserDataService(UserDataService $userDataService)
    {
        $this->userDataService = $userDataService;
    }

    /**
     * getUserDataService
     *
     * @return UserDataService
     */
    public function getUserDataService()
    {
        return $this->userDataService;
    }

    /**
     * setUserPropertyService
     *
     * @param UserPropertyService $userPropertyService userPropertyService
     *
     * @return void
     */
    public function setUserPropertyService(UserPropertyService $userPropertyService)
    {
        $this->userPropertyService = $userPropertyService;
    }

    /**
     * getUserPropertyService
     *
     * @return UserPropertyService
     */
    public function getUserPropertyService()
    {
        return $this->userPropertyService;
    }

    /**
     * setUserAuthService
     *
     * @param UserAuthenticationService $userAuthService userAuthService
     *
     * @return void
     */
    public function setUserAuthService(UserAuthenticationService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    /**
     * getUserAuthService
     *
     * @return UserAuthenticationService
     */
    public function getUserAuthService()
    {
        return $this->userAuthService;
    }

    /**
     * setUserAuthorizeService: ACL Service
     *
     * @param UserAuthorizeService $userAuthorizeService userAuthorizeService
     *
     * @return void
     */
    public function setUserAuthorizeService(
        UserAuthorizeService $userAuthorizeService
    ) {
        $this->userAuthorizeService = $userAuthorizeService;
    }

    /**
     * getUserAuthorizeService: ACL service
     *
     * @return mixed
     */
    public function getUserAuthorizeService()
    {
        return $this->userAuthorizeService;
    }

    /** HELPERS ***************************************/

    /**
     * getRegisteredUser
     *
     * @param User $user user
     *
     * @return null|User
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
     * getSessUser
     *
     * @return User
     */
    public function getSessUser()
    {
        $user = $this->getIdentity();

        return $user;
    }

    /**
     * getLoggedInUser
     *
     * @return User
     */
    public function getLoggedInUser()
    {
        $user = $this->getIdentity();

        return $user;
    }
    /**
     * getNewUser
     *
     * @return User
     */
    public function getNewUser()
    {
        return $this->buildNewUser();
    }

    /**
     * isRegistered
     *
     * @param User $user user
     *
     * @return bool
     */
    public function isRegistered(User $user)
    {
        return $this->userExists($user);
    }

    /**
     * userExists
     *
     * @param User $user user
     *
     * @return bool
     */
    public function userExists(User $user)
    {
        $result = $this->readUser($user);

        return $result->isSuccess();
    }

    /**
     * isSessUser
     *
     * @param User $user user
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
        if ($user->getId() === $sessUser->getId()
            || $user->getUsername() === $sessUser->getUsername()
        ) {

            return true;
        }

        return false;
    }

    /* CRUD HELPERS ***********************************/

    /**
     * readUser
     *
     * @param User $user user
     *
     * @return Result
     */
    public function readUser(User $user)
    {
        return $this->getUserDataService()->readUser($user);
    }

    /**
     * createUser
     *
     * @param User $user user
     *
     * @return Result
     */
    public function createUser(User $user)
    {
        return $this->getUserDataService()->createUser($user);
    }

    /**
     * updateUser
     *
     * @param User $user user
     *
     * @return Result
     */
    public function updateUser(User $user)
    {
        return $this->getUserDataService()->updateUser($user);
    }

    /**
     * deleteUser
     *
     * @param User $user user
     *
     * @return Result
     */
    public function deleteUser(User $user)
    {
        return $this->getUserDataService()->deleteUser($user);
    }

    /* PROPERTY HELPERS *******************************/

    /**
     * getUserProperty
     *
     * @param User   $user              user
     * @param string $propertyNameSpace propertyNameSpace
     * @param mixed  $dflt              dflt
     * @param bool   $refresh           refresh
     *
     * @return mixed
     */
    public function getUserProperty(
        User $user,
        $propertyNameSpace,
        $dflt = null,
        $refresh = false
    ) {
        return $this->getUserPropertyService()->getUserProperty(
            $user,
            $propertyNameSpace,
            $dflt,
            $refresh
        );
    }

    /**
     * getCurrentUserProperty
     *
     * @param string $propertyNameSpace propertyNameSpace
     * @param null   $dflt              dflt
     * @param bool   $refresh           refresh
     *
     * @return mixed
     */
    public function getCurrentUserProperty(
        $propertyNameSpace, $dflt = null, $refresh = false
    ) {
        $user = $this->getSessUser();

        if (empty($user)) {

            return $dflt;
        }

        return $this->getUserProperty($user, $propertyNameSpace, $dflt, $refresh);

    }

    /**
     * disableUser @todo WRITE THIS
     *
     * @param User $user user
     *
     * @return void
     */
    public function disableUser(User $user)
    {
    }

    /* AUTHENTICATION HELPERS ********************************/

    /**
     * logIn
     *
     * @param User $user user
     *
     * @return Result
     */
    public function logIn(User $user)
    {
        return $this->authenticate($user);
    }

    /**
     * logOut
     *
     * @return void
     */
    public function logOut()
    {
        return $this->clearIdentity();
    }

    /**
     * validateCredentials
     *
     * @param User $user user
     *
     * @return Result
     */
    public function validateCredentials(User $user)
    {
        return $this->getUserAuthService()->validateCredentials($user);
    }

    /**
     * authenticate
     *
     * @param User $user user
     *
     * @return Result
     */
    public function authenticate(User $user)
    {
        return $this->getUserAuthService()->authenticate($user);
    }

    /**
     * clearIdentity
     *
     * @return void
     */
    public function clearIdentity()
    {
        return $this->getUserAuthService()->clearIdentity();
    }

    /**
     * getIdentity
     *
     * @return User
     */
    public function getIdentity()
    {
        return $this->getUserAuthService()->getIdentity();
    }

    /* ACL HELPERS ********************************/

    /**
     * isAllowed
     *
     * @param string|AclResource $resource  resource
     * @param null               $privilege privilege
     * @param null               $user      user
     *
     * @return bool
     */
    public function isAllowed($resource, $privilege = null, $user = null)
    {
        return $this->getUserAuthorizeService()->isAllowed(
            $resource,
            $privilege,
            $user
        );
    }

    /* UTILITIES **************************************/
    /**
     * buildNewUser
     *
     * @return User
     */
    public function buildNewUser()
    {
        $user = new User();

        return $user;
    }
}