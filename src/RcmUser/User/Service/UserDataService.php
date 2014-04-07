<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Service;

use RcmUser\Event\EventProvider;
use RcmUser\User\Db\UserDataMapperInterface;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use Zend\Crypt\Password\PasswordInterface;

/**
 * CRUD Operations
 * Class UserDataService
 *
 * @package RcmUser\Service
 */
class UserDataService extends EventProvider
{

    /**
     * @var UserDataMapperInterface
     */
    protected $userDataMapper;


    /**
     * @var UserValidatorServiceInterface
     */
    protected $userValidatorService;

    protected $userDataPrepService;

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
     * @param UserValidatorServiceInterface $userValidatorService
     */
    public function setUserValidatorService(UserValidatorServiceInterface $userValidatorService)
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
     * @param UserDataPrepServiceInterface $userDataPrepService
     */
    public function setUserDataPrepService(UserDataPrepServiceInterface $userDataPrepService)
    {
        $this->userDataPrepService = $userDataPrepService;
    }

    /**
     * @return mixed
     */
    public function getUserDataPrepService()
    {
        return $this->userDataPrepService;
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

        $resultUser = new User();
        $resultUser->populate($user);

        // @event pre  - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('userToCreate' => $user, 'resultUser' => $resultUser), function($result){ return !$result->isSuccess();});

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
     * This will read the user. Id will get priority if it is set.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function readUser(User $user)
    {
        $resultUser = new User();
        $resultUser->populate($user);

        // @event pre - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('userToRead' => $user, 'resultUser' => $resultUser), function($result){ return !$result->isSuccess();});

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

        $resultUser = $existingUserResult->getUser();

        // @event pre  - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('resultUser' => $resultUser, 'updatedUser' => $user), function($result){ return !$result->isSuccess();});

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

        // @event pre  - expects listener to return RcmUser\User\Result
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

} 