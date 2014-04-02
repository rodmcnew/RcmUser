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

use RcmUser\Model\Event\EventProvider;
use RcmUser\Model\User\Db\UserDataMapperInterface;
use RcmUser\Model\User\Entity\User;
use RcmUser\Model\User\Result;
use Zend\Crypt\Password\PasswordInterface;

/**
 * CRUD Operations
 * Class RcmUserDataService
 *
 * @package RcmUser\Service
 */
class RcmUserDataService extends EventProvider
{

    /**
     * @var UserDataMapperInterface
     */
    protected $userDataMapper;

    /**
     * @var PasswordInterface
     */
    protected $encryptor;

    /**
     * @var
     */
    protected $userValidatorService;

    /**
     * @param mixed $userDataMapper
     */
    public function setUserDataMapper(UserDataMapperInterface $userDataMapper)
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
     * @param User $user
     *
     * @return Result
     */
    public function createUser(User $user)
    {

        $result = $this->readUser($user);

        if ($result->isSuccess()) {

            // ERROR - user exists
            return new Result(null, Result::CODE_FAIL, 'User already exists.');
        }

        // @event pre  - expects listener to return RcmUser\Model\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('userToCreate' => $user), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            return $resultsPre->last();
        }

        $preparedUser = $resultsPre->last()->getUser();

        // @todo Inject this as event?
        $this->getUserDataMapper()->create($preparedUser);
        $result = $this->readUser($preparedUser);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * This will read the user from Id or Username. Id will get priority if it is set.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function readUser(User $user)
    {
        // @event pre - expects listener to return RcmUser\Model\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('userToRead' => $user), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            return $resultsPre->last();
        }

        // @todo Inject this as event?
        $result = $this->getUserDataMapper()->read($user);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

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
        // require id
        if (empty($user->getId())) {

            return new Result(null, Result::CODE_FAIL, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->readUser($user);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        // @event pre  - expects listener to return RcmUser\Model\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('existingUser' => $existingUser, 'updatedUser' => $user), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            return $resultsPre->last();
        }

        $preparedUser = $resultsPre->last()->getUser();

        // @todo Inject this as event?
        // set properties
        $result = $this->getUserDataMapper()->update($preparedUser);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

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
        $existingUserResult = $this->readUser($user);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        // @event pre  - expects listener to return RcmUser\Model\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('userToDelete' => $existingUser), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            return $resultsPre->last();
        }

        // @todo Inject this as event
        $deletedUser = new User();
        $deletedUser->populate($existingUser);

        $result = $this->getUserDataMapper()->delete($existingUser);

        // User object may be cleared on delete, so we send a copy to the post event for any addition data changes or roll-backs
        $result->setUser($deletedUser);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
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