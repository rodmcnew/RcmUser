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

    protected $defaultUserState = 'disabled';

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
     * @param string $defaultUserState
     */
    public function setDefaultUserState($defaultUserState)
    {
        $this->defaultUserState = $defaultUserState;
    }

    /**
     * @return string
     */
    public function getDefaultUserState()
    {
        return $this->defaultUserState;
    }

    /**
     * @param User  $newUser
     * @param array $params
     *
     * @return mixed|Result
     */
    public function createUser(User $newUser, $params = array())
    {

        $result = $this->readUser($newUser, $params);

        if ($result->isSuccess()) {

            // ERROR - user exists
            return new Result(null, Result::CODE_FAIL, 'User already exists.');
        }

        $creatableUser = new User();
        $creatableUser->populate($newUser);

        if(empty($creatableUser->getState())){
            $creatableUser->setState($this->getDefaultUserState());
        }

        // @event pre  - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('newUser' => $newUser, 'creatableUser' => $creatableUser), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            $resultPre = $resultsPre->last();
            $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $resultPre));

            return $resultPre;
        }

        $this->getUserDataMapper()->create($creatableUser, $params);
        $result = $this->readUser($creatableUser, $params);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User  $readUser
     * @param array $params
     *
     * @return mixed
     */
    public function readUser(User $readUser, $params = array())
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

        $result = $this->getUserDataMapper()->read($readableUser, $params);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User  $updatedUser
     * @param array $params
     *
     * @return mixed|Result
     */
    public function updateUser(User $updatedUser, $params = array())
    {
        // require id
        if (empty($updatedUser->getId())) {

            return new Result(null, Result::CODE_FAIL, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->readUser($updatedUser, $params);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        $updatedUser->merge($existingUser);

        $updatableUser = new User();

        $updatableUser->populate($existingUser);

        if(empty($updatableUser->getState())){
            $updatableUser->setState($this->getDefaultUserState());
        }

        // @event pre  - expects listener to return RcmUser\User\Result
        $resultsPre = $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('updatedUser' => $updatedUser, 'updatableUser' => $updatableUser), function($result){ return !$result->isSuccess();});

        if ($resultsPre->stopped()) {

            $resultPre = $resultsPre->last();
            $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $resultPre));

            return $resultPre;
        }

        // set properties
        $result = $this->getUserDataMapper()->update($updatableUser, $params);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

    /**
     * @param User  $deleteUser
     * @param array $params
     *
     * @return mixed|Result
     */
    public function deleteUser(User $deleteUser, $params = array())
    {
        // require id
        if (empty($deleteUser->getId())) {

            return new Result(null, Result::CODE_FAIL, 'User Id required for update.');
        }

        // check if exists
        $existingUserResult = $this->readUser($deleteUser, $params);

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

        //
        $result = $this->getUserDataMapper()->delete($deletableUser, $params);

        // @event post - expects Listener to check for $result->isSuccess() for post actions
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('result' => $result));

        return $result;
    }

} 