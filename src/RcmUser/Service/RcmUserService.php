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

use RcmUser\Model\User\DataMapperInterface;
use RcmUser\Model\User\Entity\UserInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;
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

    /**  ******************/

    /**
     * @param $id
     *
     * @return null|UserInterface
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
     * @return UserInterface
     */
    public function getNewUser()
    {

        return $this->buildNewUser();
    }

    /**
     * @return bool
     */
    public function isRegistered(UserInterface $user)
    {
        return $this->exists($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function exists(UserInterface $user)
    {

        $realUser = $this->readUser($user);

        if (!empty($realUser)) {

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isCurrent(UserInterface $user)
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
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function saveUser(UserInterface $user)
    {

        if ($user->isRegistered()) {

            return $this->updateUser($user);
        }

        return $this->createUser($user);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function readUser(UserInterface $user)
    {
        // @event pre
        //$this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user));

        $user = $this->userDataMapper->fetch($user);

        // @event post
        //$this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('user' => $user));

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function createUser(UserInterface $user)
    {
        $id = $user->getId();

        if (empty($id)) {

            $user->setId($this->buildId());
        }
        // @todo VALIDATIONS and PASSWORD HASH
        // @event pre
        $this->userDataMapper->store($user);
        $newuser = $this->readUser($user);

        // @event post

        return $newuser;

    }

    /**
     * @param UserInterface $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function updateUser(UserInterface $user)
    {

        // @todo VALIDATIONS and PASSWORD HASH if changed

        // @event pre
        $this->userDataMapper->write($user);
        $updateduser = $this->readUser($user);

        // @event post

        return $updateduser;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     * @throws \Exception
     */
    public function deleteUser(UserInterface $user)
    {
        $id = $user->getId();
        $saved = $user->isRegistered();

        if (empty($id) || $saved == false) {

            throw new \Exception('id not set or user was never saved.');
        }

        // @event pre
        $this->userDataMapper->clear();
        $unsavedUser = new User();
        $unsavedUser->setId($id);

        // @event post

        return $unsavedUser;
    }

    /**
     * @return UserInterface
     */
    public function buildNewUser()
    {

        $user = new User();

        return $user;
    }

    /* AUTHENTICATION ***********************/

    public function authenticate(UserInterface $user)
    {

        // Get credentials
        // hash password
        // check match
        // @event pre

        // @event post
        return true;
    }

    public function authenticateToSess(UserInterface $user)
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

        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->getConfig->get('passwordCost', 14));

        return $bcrypt->create($password);
    }

} 