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
    public function getRegisteredUser($id)
    {

        if ($id !== null) {

            $user = $this->readUser($id);

            return $user;
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

        $realUser = $this->readUser($user);

        if ($realUser instanceof RcmUserException) {

            return false;
        }

        return true;
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

        if ($user->getId() === $sessUser->getId() || $user->getUsername() === $sessUser->getUsername()) {

            return true;
        }

        return false;
    }

    /* CRUD **************************/

    /**
     * @param $id
     *
     * @return mixed
     */
    public function readUser(AbstractUser $user)
    {
        // @todo might cache users into memory here
        // @event pre
        //$this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user));

        $user = $this->userDataMapper->read($user);

        // @event post
        //$this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('user' => $user));

        return $user;
    }

    /**
     * @param AbstractUser $user
     *
     * @return mixed
     */
    public function createUser(AbstractUser $user)
    {

        if ($this->userExists($user)) {

            // ERROR - user exists
            return new RcmUserException('User already exists.');
        }

        // VALIDATIONS
        $user = $this->validateUser($user);

        if($user instanceof InvalidInputException){

            return $user;
        }

        // @event pre
        $user->setId($this->buildId());
        $user->setPassword($this->encryptPassword($user->getPassword()));

        $this->userDataMapper->create($user);
        $newuser = $this->readUser($user);

        // @event post

        return $newuser;

    }

    /**
     * @param AbstractUser $user
     *
     * @return mixed
     * @throws \RcmUserException
     */
    public function updateUser(AbstractUser $user)
    {

        if (!$this->userExists($user)) {

            // ERROR - user exists
            return new RcmUserException('User does not exist or could not be found.');
        }

        // VALIDATIONS
        $validUser = $this->validateUser($user);

        if($validUser instanceof InvalidInputException){

            return $validUser;
        }

        // @event pre
        // set properties
        $existingUser = $this->readUser($validUser);
        $existingId = $existingUser->getId();
        $existingHash = $existingUser->getPassword();
        $newHash = $this->encryptPassword($validUser->getPassword());
        $existingUser->populate($validUser);
        $existingUser->setId($existingId);

        // update password if changed
        if (!$this->isValidPassword($existingHash, $newHash)) {

            //password has change, encrypt it
            $existingUser->setPassword($newHash);
        } else {

            // no change
            $existingUser->setPassword($existingHash);
        }

        $updateduser = $this->userDataMapper->update($existingUser);

        // @event post
        return $updateduser;
    }

    /**
     * @param AbstractUser $user
     *
     * @return AbstractUser
     * @throws \RcmUserException
     */
    public function deleteUser(AbstractUser $user)
    {
        if (!$this->userExists($user)) {

            // ERROR - user exists
            return new RcmUserException('User does not exist or could not be found.');
        }

        // @event pre
        $this->userDataMapper->delete($user);
        $unsavedUser = new User();

        // @event post

        return $unsavedUser;
    }

    public function disableUser(AbstractUser $user)
    {

        // @todo write me
    }

    public function validateUser(AbstractUser $user)
    {

        $inputFilter = $this->getUserInputFilter();

        $inputFilter->setData($user);

        if ($inputFilter->isValid()) {

            $user->populate($inputFilter->getValues());

            return $user;
        } else {

            $errors = array();

            foreach ($inputFilter->getInvalidInput() as $key => $error) {

                $errors[$key] = $error->getMessages();
            }

            $exception = new InvalidInputException("User is imput not valid");
            $exception->setInputMessages($errors);

            return $exception;
        }
    }

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