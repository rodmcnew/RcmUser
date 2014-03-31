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

use RcmUser\Model\User\Db\DataMapperInterface;
use RcmUser\Model\User\Entity\User;
use RcmUser\Model\User\Result;
use Zend\Crypt\Password\PasswordInterface;
use ZfcBase\EventManager\EventProvider;

//use ZfcUser\Service\User;

/**
 * Class RcmUserService
 *
 * @package RcmUser\Service
 */
class RcmUserService extends EventProvider
{
    /**
     * @var array
     */
    protected $config = array();

    /**
     * @var DataMapperInterface
     */
    protected $userDataMapper;

    /**
     * @var
     */
    protected $sessionUserStorage;

    /**
     * @var
     */
    protected $userValidatorService;

    /**
     * @var
     */
    protected $authService;

    /**
     * @var PasswordInterface
     */
    protected $encryptor;

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {

        $this->config = $config;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {

        return $this->config;
    }

    /**
     * @param mixed $userDataMapper
     */
    public function setUserDataMapper(DataMapperInterface $userDataMapper)
    {
        $this->userDataMapper = $userDataMapper;
    }

    /**
     * @return mixed
     */
    public function getUserDataMapper()
    {
        return $this->userDataMapper;
    }

    /**
     * @param mixed $sessionUserStorage
     */
    public function setSessionUserStorage($sessionUserStorage)
    {
        $this->sessionUserStorage = $sessionUserStorage;
    }

    /**
     * @return mixed
     */
    public function getSessionUserStorage()
    {
        return $this->sessionUserStorage;
    }

    /**
     * @param mixed $userValidatorService
     */
    public function setUserValidatorService($userValidatorService)
    {
        $this->userValidatorService = $userValidatorService;
    }

    /**
     * @return mixed
     */
    public function getUserValidatorService()
    {
        return $this->userValidatorService;
    }

    /**
     * @param mixed $authService
     */
    public function setAuthService($authService)
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
     * @param PasswordInterface $encryptor
     */
    public function setEncryptor(PasswordInterface $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @return PasswordInterface
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /** HELPERS ***************************************/

    /**
     * @param $id
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
     * @return mixed
     */
    public function getSessUser()
    {
        // @todo Need storage to have id
        $user = $this->sessionUserStorage->read();

        // Must get session id too!

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

    /* RELATED HELPERS *******************************/

    /**
     * @param $user
     * @param $permisions
     */
    public function getUserAccess($user, $permisions)
    {
    }

    /**
     * @param $permisions
     */
    public function getCurrentUserAccess($permisions)
    {
        // check session
    }

    /**
     * @param User $user
     * @param string $propertyNameSpace
     * @param bool $refresh
     *
     * @return array|mixed|null
     */
    public function getUserProperty(User $user, $propertyNameSpace = null, $refresh = false)
    {
        $property = $user->getProperty($propertyNameSpace, null);

        if($property === null || $refresh){
            // @event getUserProperty.pre - expects the listener to short-circuit if it is the matching namespace
            $results = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user, $propertyNameSpace));
            $property = $results->last();
        }

        return $property;

    }

    /**
     * @param string $propertyNameSpace
     * @param bool $refresh
     *
     * @return array|mixed|null
     */
    public function getCurrentUserProperty($propertyNameSpace = null, $refresh = false)
    {
        $user = $this->readSessUser();

        if(empty($user)){

            // @todo return result so the requester can know why
            return null;
        }

        return $this->getUserProperty($user, $propertyNameSpace, $refresh);

    }

    /* CRUD ******************************************/

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function readUser(User $user)
    {
        // @event readUser.pre
        $results = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user));

        // Expect Results, is any failed, then fail
        // @todo This will be an issue is multiple things are changing the user.
        foreach ($results as $eventResult) {

            if (!$eventResult->isSuccess()) {

                $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $eventResult, 'results' => $results));

                return $eventResult;
            }
        }

        // @todo Inject this as event
        $result = $this->getUserDataMapper()->read($user);

        // @event createUser.success/fail
        if ($result->isSuccess()) {

            $this->getEventManager()->trigger(__FUNCTION__ . '.success', $this, array('result' => $result));
        } else {

            $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $result, 'results' => null));
        }

        return $result;
    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function createUser(User $user)
    {

        if ($this->userExists($user)) {

            // ERROR - user exists
            return new Result(null, Result::CODE_FAIL, 'User already exists.');
        }

        // @event createUser.pre
        $results = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('newUser' => $user));

        // Expect Results, is any failed, then fail
        // @todo This will be an issue is multiple things are changing the user.
        foreach ($results as $eventResult) {

            if (!$eventResult->isSuccess()) {

                $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $eventResult, 'results' => $results));

                return $eventResult;
            }
        }

        $preparedUser = $results->last()->getUser();
        /* -event */
        // @todo Inject this as event
        $this->getUserDataMapper()->create($preparedUser);
        $result = $this->readUser($preparedUser);

        // @event createUser.success/fail
        if ($result->isSuccess()) {

            $this->getEventManager()->trigger(__FUNCTION__ . '.success', $this, array('result' => $result));
        } else {

            $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $result, 'results' => null));
        }

        return $result;
    }

    /**
     * @param User $user (updated user,
     *
     * @return Result
     * @throws \RcmUserException
     */
    public function updateUser(User $user)
    {
        // @todo Inject this as event
        // require id
        if (empty($user->getId())) {

            return new Result(null, Result::CODE_FAIL, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->getUserDataMapper()->fetchById($user->getId());

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        // @event updateUser.pre
        $results = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('existingUser' => $existingUser, 'updatedUser' => $user));

        // Expect Results, is any failed, then fail
        // @todo This will be an issue is multiple things are changing the user.
        foreach ($results as $eventResult) {

            if (!$eventResult->isSuccess()) {

                $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $eventResult, 'results' => $results));

                return $eventResult;
            }
        }

        $preparedUser = $results->last()->getUser();

        // @todo Inject this as event
        // set properties
        $result = $this->getUserDataMapper()->update($preparedUser);

        // @event updateUser.success/fail
        if ($result->isSuccess()) {

            $this->getEventManager()->trigger(__FUNCTION__ . '.success', $this, array('result' => $result));
        } else {

            $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $result, 'results' => null));
        }

        return $result;
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws \RcmUserException
     */
    public function deleteUser(User $user)
    {
        // @todo Inject this as event
        // require id
        if (empty($user->getId())) {

            return new Result(null, Result::CODE_FAIL, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->getUserDataMapper()->fetchById($user->getId());

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        // @event deleteUser.pre
        $results = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $existingUser));

        // Expect Results, is any failed, then fail
        // @todo This will be an issue is multiple things are changing the user.
        foreach ($results as $eventResult) {

            if (!$eventResult->isSuccess()) {

                $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $eventResult, 'results' => $results));

                return $eventResult;
            }
        }

        // @todo Inject this as event
        $this->getUserDataMapper()->delete($existingUser);
        $unsavedUser = new User();
        $result = new Result($unsavedUser);

        // @event updateUser.success/fail
        if ($result->isSuccess()) {

            $this->getEventManager()->trigger(__FUNCTION__ . '.success', $this, array('result' => $result));
        } else {

            $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $result, 'results' => null));
        }

        return $result;
    }

    /**
     * @param User $user
     */
    public function disableUser(User $user)
    {

        // @todo write me
    }

    /* AUTHENTICATION ********************************/

    /**
     * @param User $user
     *
     * @return Result
     */
    public function logIn(User $user)
    {

        return $this->authenticateToSess($user);
    }

    public function logOut()
    {

        return $this->clearAuthSess();
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
        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        return $adapter->authenticate();

        // @event authenticate.fail
        $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('successResult' => null, 'results' => $eventResults));

        return $eventResults->last();


    }

    /**
     * @param User $user
     *
     * @return Result
     */
    public function authenticateToSess(User $user)
    {

        // @event authenticateToSess.pre
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

        // @event authenticateToSess.fail
        $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('successResult' => null, 'results' => $eventResults));

        return $eventResults->last();
    }

    public function clearSessUser()
    {
        $currentUser = $this->readSessUser();

        // @event clearSessUser
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));

        // @todo Inject this as event
        $authService = $this->getAuthService();

        if ($authService->hasIdentity()) {
            $authService->clearIdentity();
        }
    }

    public function readSessUser(){

        $authService = $this->getAuthService();
        return $authService->getIdentity();
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

    /**
     * @return string
     */
    public function buildId()
    {

        return $this->guidv4();
    }

    /**
     * @return string
     */
    public function guidv4()
    {
        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0010
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}