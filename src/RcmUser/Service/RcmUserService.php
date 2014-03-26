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
use RcmUser\Service\Exception\InvalidInputException;
use Zend\Crypt\Password\Bcrypt;
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
     * @var DataMapperInterface
     */
    protected $userDataMapper;

    /**
     * @var
     */
    protected $sessionUserStorage;

    /**
     * @var array
     */
    protected $config = array();

    /**
     * @var InputFilter
     */
    protected $userInputFilter;

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
     * @param \Zend\InputFilter\InputFilter $userInputFilter
     */
    public function setUserInputFilter(InputFilter $userInputFilter)
    {
        $this->userInputFilter = $userInputFilter;
    }

    /**
     * @return \Zend\InputFilter\InputFilter
     */
    public function getUserInputFilter()
    {
        return $this->userInputFilter;
    }

    /**  ******************/

    /**
     * @param $id
     *
     * @return null|AbstractUser
     */
    public function getRegisteredUser(AbstractUser $user)
    {
        // @todo Clean this up
        if (!empty($user->getId())) {


            return $this->readUser($user);
        }

        return new Result(null, 0, 'Id required');
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
    public function isCurrent(AbstractUser $user)
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

    /* CRUD **************************/

    /**
     * @param $id
     *
     * @return Result
     */
    public function readUser(AbstractUser $user)
    {
        // @todo might cache users
        // @event onBeforeReadUser
        //$this->getEventManager()->trigger('onBefore'.ucfirst(__METHOD__), $this, array('user' => $user));

        $result = $this->userDataMapper->read($user);

        // @event onReadUserSuccess / onReadUserFail
        //$this->getEventManager()->trigger('on'.ucfirst(__METHOD__).'Success', $this, array('user' => $user));

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
            return new Result(null, 0, 'User already exists.');
        }

        // @event onBeforeCreate

        /* +EVENT */
        //@todo inject as event
        $onBeforeCreateResult = $this->onBeforeCreate($user);

        if(!$onBeforeCreateResult->isSuccess()){

            return $onBeforeCreateResult;
        }

        $preparedUser = $onBeforeCreateResult->getUser();
        /* -EVENT */

        $this->userDataMapper->create($preparedUser);
        $result = $this->readUser($preparedUser);

        // @event onCreateSuccess / onCreateFail

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

            return new Result(null, 0, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->userDataMapper->fetchById($user->getId());

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        // @event onBeforeUpdate

        /* +EVENT */
        //@todo inject as event
        $onBeforeUpdateResult = $this->onBeforeUpdate($existingUser, $user);

        if(!$onBeforeUpdateResult->isSuccess()){

            return $onBeforeUpdateResult;
        }

        $preparedUser = $onBeforeUpdateResult->getUser();
        /* -EVENT */

        // set properties
        $updatedUserResult = $this->userDataMapper->update($preparedUser);

        // @event onUpdateSuccess / onUpdateFail

        return $updatedUserResult;
    }

    /**
     * @param AbstractUser $user
     *
     * @return AbstractUser
     * @throws \RcmUserException
     */
    public function deleteUser(AbstractUser $user)
    {
        // @todo might restrict this to just Id
        $existingUserResult = $this->readUser($user);

        if (!$existingUserResult->isSuccess()) {

            // ERROR - user exists
            $existingUserResult->setMessage(__METHOD__, 'User does not exist or could not be found.');

            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        // @event onBeforeDelete
        $this->userDataMapper->delete($existingUser);
        $unsavedUser = new User();

        // @event onDeleteSuccess / onDeleteFail

        return new Result($unsavedUser);
    }

    public function disableUser(AbstractUser $user)
    {

        // @todo write me
    }

    /* +EVENTS ******************************/

    /**
     * @param AbstractUser $existingUser
     * @param AbstractUser $user
     *
     * @return Result
     */
    public function onBeforeUpdate(AbstractUser $existingUser, AbstractUser $user)
    {
        // @todo create temp user for roll-back in case of error

        // USERNAME CHECKS
        $newUsername = $user->getUsername();
        $existingUserName = $existingUser->getUsername();

        // sync null
        if ($newUsername !== null) {

            // if username changed:
            if ($existingUserName !== $newUsername) {

                // make sure no duplicates
                $dupUser = $this->userDataMapper->fetchByUsername($newUsername);

                if ($dupUser->isSuccess()) {

                    // ERROR - user exists
                    return new Result(null, 0, 'User could not be prepared, duplicate username.');
                }

                $existingUser->setUsername($newUsername);
            }
        }

        // PASSWORD CHECKS
        $newPassword = $user->getPassword();
        $existingPassword = $existingUser->getPassword();
        $hashedPassword = $existingPassword;
        // sync null
        if ($newPassword !== null) {
            // if password changed
            if ($existingPassword !== $newPassword) {
                // plain text
                $existingUser->setPassword($newPassword);
                $hashedPassword = $this->encryptPassword($newPassword);
            }
        }

        // run validation rules
        $validateResult = $this->validateUser($existingUser);

        if (!$validateResult->isSuccess()) {

            return $validateResult;
        }

        // if valid:
        $existingUser->setPassword($hashedPassword);

        return new Result($existingUser);
    }

    /**
     * @param AbstractUser $user
     *
     * @return Result
     */
    public function onBeforeCreate(AbstractUser $user){

        // @todo create temp user for roll-back in case of error

        // run validation rules
        $validateResult = $this->validateUser($user);

        if (!$validateResult->isSuccess()) {

            return $validateResult;
        }

        $user->setId($this->buildId());
        $user->setPassword($this->encryptPassword($user->getPassword()));

        return new Result($user);
    }

    /**
     * @param $user
     *
     * @return Result
     */
    public function validateUser(AbstractUser $user)
    {

        $inputFilter = $this->getUserInputFilter();

        $inputFilter->setData($user);

        if ($inputFilter->isValid()) {

            $user->populate($inputFilter->getValues());

            return new Result($user);
        } else {

            $result = new Result($user, 0, 'User input not valid');

            foreach ($inputFilter->getInvalidInput() as $key => $error) {

                $result->setMessage($key, $error->getMessages());
            }

            return $result;
        }
    }

    /* -EVENTS */

    /**
     * @return AbstractUser
     */
    public function buildNewUser()
    {

        $user = new User();

        return $user;
    }

    /* AUTHENTICATION ***********************/

    public function authenticate(AbstractUser $user)
    {
        if (!$this->userExists($user)) {

            // ERROR - user exists
            return new RcmUserException('User does not exist or could not be found.');
        }

        $existingUser = $this->readUser($user);
        $existingHash = $existingUser->getPassword();
        $newHash = $this->encryptPassword($user->getPassword());

        // @event pre

        // @event post
        return $this->isValidPassword($existingHash, $newHash);
    }

    public function authenticateToSess(AbstractUser $user)
    {

        if ($this->authenticate($user)) {

            // Add to session
        }

        return user;
    }

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

    /* UTILITIES ************************/

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
    protected function guidv4()
    {
        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0010
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    protected function encryptPassword($password)
    {

        $bcrypt = new Bcrypt();
        $bcrypt->setCost($this->getConfig()->get('passwordCost', 14));

        return $bcrypt->create($password);
    }

    protected function isValidPassword($credential, $password)
    {

        $bcrypt = new Bcrypt();
        $bcrypt->setCost($this->getConfig()->get('passwordCost', 14));

        return $bcrypt->verify($credential, $password);
    }


}