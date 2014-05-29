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

use RcmUser\Acl\Service\AuthorizeService;
use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\Exception\RcmUserException;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use RcmUser\User\Service\UserDataService;
use RcmUser\User\Service\UserPropertyService;

//use ZfcUser\Service\User;

/**
 * Class RcmUserService
 *
 * RcmUserService facade
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
     * @var AuthorizeService
     */
    protected $authorizeService;

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
     * setAuthorizeService: ACL Service
     *
     * @param AuthorizeService $authorizeService authorizeService
     *
     * @return void
     */
    public function setAuthorizeService(
        AuthorizeService $authorizeService
    ) {
        $this->authorizeService = $authorizeService;
    }

    /**
     * getAuthorizeService: ACL service
     *
     * @return mixed
     */
    public function getAuthorizeService()
    {
        return $this->authorizeService;
    }

    /** HELPERS ***************************************/

    /**
     * getUser
     *
     * @param User $user user
     *
     * @return null|User
     */
    public function getUser(User $user)
    {
        // @todo - check all sources (db and session)?
        $result = $this->readUser($user);

        if ($result->isSuccess()) {

            return $result->getUser();
        }

        return null;
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
        $sessUser = $this->getIdentity();

        if (empty($sessUser)) {

            return false;
        }

        // @todo make sure this is a valid check for all cases
        if (!empty($user->getId())
            && $user->getId() === $sessUser->getId()
        ) {

            return true;
        }

        if (!empty($user->getUsername())
            && $user->getUsername() === $sessUser->getUsername()
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
        $propertyNameSpace,
        $dflt = null,
        $refresh = false
    ) {
        $user = $this->getIdentity();

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
     * hasIdentity
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->getUserAuthService()->hasIdentity();
    }

    /**
     * setIdentity
     *
     * @param User $user user
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function setIdentity(User $user)
    {
        $currentUser = $this->getIdentity();

        if (empty($currentUser) || $user->getId() !== $currentUser->getId()) {

            throw new RcmUserException(
                'SetIdentity expects user to be get same identity as current, ' .
                'user authenticate to change users.'
            );
        }

        return $this->getUserAuthService()->setIdentity($user);
    }

    /**
     * refreshIdentity
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function refreshIdentity()
    {
        $currentUser = $this->getIdentity();

        if(empty($currentUser)){

            return null;
        }

        $user = $this->readUser($currentUser);

        if (empty($user->getId())) {

            throw new RcmUserException(
                'RefreshIdentity expects user to be get same identity as current.'
            );
        }

        return $this->getUserAuthService()->setIdentity($user);
    }

    /**
     * getIdentity - get logged in user
     *
     * @return User
     */
    public function getIdentity()
    {
        return $this->getUserAuthService()->getIdentity();
    }

    /**
     * getCurrentUser
     * Get current logged in user or default if no one is logged in
     * @param mixed $default default
     *
     * @return User|null
     */
    public function getCurrentUser($default = null)
    {
        $user = $this->getIdentity();
        return $user;
    }

    public function getTempUser()
    {

    }

    //@todo implement guestIdentity and hasIdentity
    // - if getIdentity is empty return guest and save updates in session
    // on login we can sync the guest user or the session user as needed

    /* ACL HELPERS ********************************/

    /**
     * isAllowed
     *
     * @param string $resourceId resourceId
     * @param string $privilege  privilege
     * @param string $providerId resource providerId
     *
     * @return bool
     */
    public function isAllowed($resourceId, $privilege = null, $providerId = null)
    {
        $user = $this->getIdentity();

        return $this->isUserAllowed($resourceId, $privilege, $providerId, $user);
    }

    /**
     * isUserAllowed
     *
     * @param string $resourceId resourceId
     * @param string $privilege  privilege
     * @param string $providerId resource providerId
     * @param User   $user       user
     *
     * @return mixed
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function isUserAllowed(
        $resourceId,
        $privilege = null,
        $providerId = null,
        $user = null
    ) {
        if (!($user instanceof User)) {

            return false;
        }

        return $this->getAuthorizeService()->isAllowed(
            $resourceId,
            $privilege,
            $providerId,
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

        return $this->buildUser($user);
    }

    /**
     * buildUser - build a user populated with defaults from event listeners
     *
     * @param User $user user
     *
     * @return User
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function buildUser(User $user)
    {
        $result = $this->getUserDataService()->buildUser($user);

        if ($result->isSuccess() || $result->getUser() == null) {

            return $result->getUser();
        } else {

            // this should not fail, if it does, something is really wrong
            throw new RcmUserException(
                'User could not be built or was not returned'
            );
        }
    }

}