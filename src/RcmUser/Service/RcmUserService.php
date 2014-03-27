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

use RcmUser\Exception\RcmUserException;
use RcmUser\Model\User\Db\DataMapperInterface;
use RcmUser\Model\User\Entity\AbstractUser;
use RcmUser\Model\User\Entity\User;
use RcmUser\Model\User\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\Password\PasswordInterface;
use Zend\InputFilter\InputFilter;
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
     * @return null|AbstractUser
     */
    public function getRegisteredUser(AbstractUser $user)
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
     * @return AbstractUser
     */
    public function getNewUser()
    {
        return $this->buildNewUser();
    }

    /**
     * @return bool
     */
    public function isRegistered(AbstractUser $user)
    {
        return $this->userExists($user);
    }

    /**
     * @param AbstractUser $user
     *
     * @return bool
     */
    public function userExists(AbstractUser $user)
    {
        $result = $this->readUser($user);

        return $result->isSuccess();
    }

    /**
     * @return bool
     */
    public function isSessUser(AbstractUser $user)
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
     * @param $permisionS
     */
    public function getCurrentUserAccess($permisionS)
    {
        // check session
    }

    /**
     * @param       $user
     * @param array $propertyNameSpace
     */
    public function getUserProperty($user, $propertyNameSpace = array())
    {
    }

    /**
     * @param array $propertyNameSpace
     */
    public function getCurrentUserProperty($propertyNameSpace = array())
    {
        // check session
    }

    /* CRUD ******************************************/

    /**
     * @param $id
     *
     * @return Result
     */
    public function readUser(AbstractUser $user)
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
     * @param AbstractUser $user
     *
     * @return Result
     */
    public function createUser(AbstractUser $user)
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
     * @param AbstractUser $user (updated user,
     *
     * @return Result
     * @throws \RcmUserException
     */
    public function updateUser(AbstractUser $user)
    {
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

        var_dump($results);
        // Expect Results, is any failed, then fail
        // @todo This will be an issue is multiple things are changing the user.
        foreach ($results as $eventResult) {

            if (!$eventResult->isSuccess()) {

                $this->getEventManager()->trigger(__FUNCTION__ . '.fail', $this, array('failResult' => $eventResult, 'results' => $results));

                return $eventResult;
            }
        }

        $preparedUser = $results->last()->getUser();

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
     * @param AbstractUser $user
     *
     * @return AbstractUser
     * @throws \RcmUserException
     */
    public function deleteUser(AbstractUser $user)
    {
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

        // @event onBeforeDelete
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
     * @param AbstractUser $user
     */
    public function disableUser(AbstractUser $user)
    {

        // @todo write me
    }

    /* AUTHENTICATION ********************************/

    /**
     * @param AbstractUser $user
     *
     * @return Result
     */
    public function authenticate(AbstractUser $user)
    {
        /* @todo MOVED to RcmUser\Model\Authentication\Adapter\RcmUserAdapter
        $username = $user->getUsername();
        $password = $user->getPassword();

        if ($username === null || $password === null) {

            return new Result(null, Result::CODE_FAIL, 'User credentials required.');
        }

        $existingUserResult = $this->getUserDataMapper()->fetchByUsername($username);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();
        $existingHash = $existingUser->getPassword();

        $credential = $user->getPassword();

        // @event pre
        $isValid = $this->getEncryptor()->verify($credential, $existingHash);
        if ($isValid) {
            $result = new Result($existingUser);
        } else {
            $result = new Result(null, Result::CODE_FAIL, 'User credentials invalid.');
        }

        // @event post

        return $result;
         * */
    }

    /**
     * @param AbstractUser $user
     *
     * @return Result
     */
    public function authenticateToSess(AbstractUser $user)
    {
        // @todo make this work correctly
        $authResult = $this->authenticate($user);
        if ($authResult->isSuccess()) {

            $existingUser = $authResult->getUser();
            $username = $user->getUsername();
            $password = $user->getPassword();

            $this->getAuthService()->getAdapter()
                ->setIdentity($username)
                ->setCredential($password);

            $result = $this->getAuthService()->authenticate();

            if ($result->isValid()) {
                $authResult = new Result($existingUser, Result::CODE_SUCCESS, $result->getMessages());
                $existingUser->setPassword(User::PASSWORD_OBFUSCATE);
                $this->getAuthService()->getStorage()->write($existingUser);
            } else {

                $authResult = new Result(null, Result::CODE_FAIL, $result->getMessages());
            }
        }

        return $authResult;
    }

    /* UTILITIES **************************************/
    /**
     * @return AbstractUser
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