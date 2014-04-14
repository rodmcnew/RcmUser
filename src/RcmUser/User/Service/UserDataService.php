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
     * @param UserDataMapperInterface $userDataMapper
     */
    public function setUserDataMapper(UserDataMapperInterface $userDataMapper)
    {
        $this->userDataMapper = $userDataMapper;
    }

    /**
     * @return UserDataMapperInterface
     */
    public function getUserDataMapper()
    {
        return $this->userDataMapper;
    }

    /**
     * @param User $newUser
     *
     * @return Result
     */
    public function createUser(User $newUser)
    {

        $result = $this->readUser($newUser);

        if ($result->isSuccess()) {

            // ERROR - user exists
            return new Result(null, Result::CODE_FAIL, 'User already exists.');
        }

        $creatableUser = new User();
        $creatableUser->populate($newUser);

        // @event pre  - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('newUser' => $newUser, 'creatableUser' => $creatableUser), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            $resultPre = $resultsPre->last();
            $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $resultPre));

            return $resultPre;
        }

        // @todo Inject this as event?
        $this->getUserDataMapper()->create($creatableUser);
        $result = $this->readUser($creatableUser);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User $readUser
     *
     * @return Result
     */
    public function readUser(User $readUser)
    {
        $readableUser = new User();
        $readableUser->populate($readUser);

        // @event pre - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('readUser' => $readUser, 'readableUser' => $readableUser), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            $resultPre = $resultsPre->last();
            $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $resultPre));

            return $resultPre;
        }

        // @todo Inject this as event?
        $result = $this->getUserDataMapper()->read($readableUser);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User $updatedUser
     *
     * @return Result
     */
    public function updateUser(User $updatedUser)
    {
        // require id
        if (empty($updatedUser->getId())) {

            return new Result(null, Result::CODE_FAIL, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->readUser($updatedUser);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $updatableUser = new User();

        $updatableUser->populate($existingUserResult->getUser());

        // @event pre  - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('updatedUser' => $updatedUser, 'updatableUser' => $updatableUser), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            $resultPre = $resultsPre->last();
            $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $resultPre));

            return $resultPre;
        }

        // @todo Inject this as event?
        // set properties
        $result = $this->getUserDataMapper()->update($updatableUser);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User $deleteUser
     *
     * @return Result
     */
    public function deleteUser(User $deleteUser)
    {
        // @todo Inject this as event
        // require id
        if (empty($deleteUser->getId())) {

            return new Result(null, Result::CODE_FAIL, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->readUser($deleteUser);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $deletableUser = new User();

        $deletableUser->populate($existingUserResult->getUser());

        // @event pre  - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('deleteUser' => $deleteUser, 'deletableUser' => $deletableUser), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            $resultPre = $resultsPre->last();
            $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $resultPre));

            return $resultPre;
        }

        // @todo Inject this as event
        $result = $this->getUserDataMapper()->delete($deletableUser);

        // User object may be cleared on delete, so we send a copy to the post event for any addition data changes or roll-backs
        $result->setUser($deleteUser);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

} 