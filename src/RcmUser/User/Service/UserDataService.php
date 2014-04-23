<?php
/**
 * UserDataService.php
 *
 * CRUD Operations
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Service;

use RcmUser\Event\EventProvider;
use RcmUser\User\Db\UserDataMapperInterface;
use RcmUser\User\Entity\ReadOnlyUser;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;

/**
 * Class UserDataService
 *
 * CRUD Operations
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserDataService extends EventProvider
{

    /**
     * @var string
     */
    protected $defaultUserState = User::STATE_DISABLED;

    /**
     * setDefaultUserState
     *
     * @param string $defaultUserState defaultUserState
     *
     * @return void
     */
    public function setDefaultUserState($defaultUserState)
    {
        $this->defaultUserState = $defaultUserState;
    }

    /**
     * getDefaultUserState
     *
     * @return string
     */
    public function getDefaultUserState()
    {
        return $this->defaultUserState;
    }

    /**
     * createUser
     *
     * @param User  $newUser newUser
     * @param array $params  params
     *
     * @return Result
     */
    public function createUser(User $newUser, $params = array())
    {
        /* + PREP - low level business logic to reduce issues */
        $result = $this->readUser($newUser, $params);

        if ($result->isSuccess()) {

            // ERROR - user exists
            return new Result(null, Result::CODE_FAIL, 'User already exists.');
        }

        $creatableUser = new User();
        $creatableUser->populate($newUser);

        $newUser = new ReadOnlyUser($newUser);

        // This is set to default
        if (empty($creatableUser->getState())) {
            $creatableUser->setState($this->getDefaultUserState());
        }
        /* - PREP */

        /* @event beforeCreateUser */
        $results = $this->getEventManager()->trigger(
            'beforeCreateUser',
            $this,
            array(
                'newUser' => $newUser,
                'creatableUser' => $creatableUser
            ),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            return $results->last();
        }

        /* @event createUser */
        $results = $this->getEventManager()->trigger(
            'createUser',
            $this,
            array(
                'newUser' => $newUser,
                'creatableUser' => $creatableUser
            ),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            $result = $results->last();

            $this->getEventManager()->trigger(
                'createUserFail',
                $this,
                array('result' => $result)
            );

            return $result;
        }

        // read created user for success return
        // this causes issues for later events
        // $result = $this->readUser($creatableUser, $params);
        $result = new Result($creatableUser);

        if(!$result->isSuccess()){
            $this->getEventManager()->trigger(
                'createUserFail',
                $this,
                array('result' => $result)
            );

            return $result;
        }

        /* @event createUserSuccess */
        $this->getEventManager()->trigger(
            'createUserSuccess',
            $this,
            array('result' => $result)
        );

        return $result;
    }

    /**
     * readUser
     *
     * @param User  $readUser readUser
     * @param array $params   params
     *
     * @return Result
     */
    public function readUser(User $readUser, $params = array())
    {
        $readableUser = new User();
        $readableUser->populate($readUser);

        $readUser = new ReadOnlyUser($readUser);

        /* @event beforeReadUser */
        $results = $this->getEventManager()->trigger(
            'beforeReadUser',
            $this, 
            array(
                'readUser' => $readUser, 
                'readableUser' => $readableUser),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            return $results->last();
        }

        /* @event readUser */
        $results = $this->getEventManager()->trigger(
            'readUser',
            $this,
            array(
                'readUser' => $readUser,
                'readableUser' => $readableUser),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            $result = $results->last();
            $this->getEventManager()->trigger(
                'readUserFail',
                $this,
                array('result' => $result)
            );

            return $result;
        }

        $result = new Result($readableUser);

        /* @event readUserSuccess */
        $this->getEventManager()->trigger(
            'readUserSuccess',
            $this,
            array('result' => $result)
        );

        return $result;
    }

    /**
     * updateUser
     *
     * @param User  $updatedUser updatedUser
     * @param array $params      params
     *
     * @return Result
     */
    public function updateUser(User $updatedUser, $params = array())
    {
        /* + PREP - low level business logic to reduce issues */
        // require id
        if (empty($updatedUser->getId())) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User Id required for update.'
            );
        }

        // check if exists
        $existingUserResult = $this->readUser($updatedUser, $params);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $existingUser = $existingUserResult->getUser();

        $existingUser = new ReadOnlyUser($existingUser);

        $updatedUser->merge($existingUser);

        $updatableUser = new User();

        $updatableUser->populate($updatedUser);

        $updatedUser = new ReadOnlyUser($updatedUser);

        if (empty($updatableUser->getState())) {
            $updatableUser->setState($this->getDefaultUserState());
        }
        /* - PREP */

        /* @event beforeUpdateUser */
        $results = $this->getEventManager()->trigger(
            'beforeUpdateUser',
            $this,
            array(
                'updatedUser' => $updatedUser,
                'updatableUser' => $updatableUser,
                'existingUser' => $existingUser
            ),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            return $results->last();
        }

        /* @event updateUser */
        $results = $this->getEventManager()->trigger(
            'updateUser',
            $this,
            array(
                'updatedUser' => $updatedUser,
                'updatableUser' => $updatableUser,
                'existingUser' => $existingUser
            ),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            $result = $results->last();
            $this->getEventManager()->trigger(
                'updateUserFail',
                $this,
                array('result' => $result)
            );

            return $result;
        }

        $result = new Result($updatableUser);

        /* @event updateUser */
        $this->getEventManager()->trigger(
            'updateUserSuccess',
            $this,
            array('result' => $result)
        );

        return $result;
    }

    /**
     * deleteUser
     *
     * @param User  $deleteUser deleteUser
     * @param array $params     params
     *
     * @return mixed|Result
     */
    public function deleteUser(User $deleteUser, $params = array())
    {
        /* + PREP - low level business logic to reduce issues */
        // require id
        if (empty($deleteUser->getId())) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User Id required for update.'
            );
        }

        // check if exists
        $existingUserResult = $this->readUser($deleteUser, $params);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return $existingUserResult;
        }

        $deletableUser = new User();

        $deletableUser->populate($existingUserResult->getUser());

        $deleteUser = new ReadOnlyUser($deleteUser);
        /* - PREP */

        /* @event beforeDeleteUser */
        $results = $this->getEventManager()->trigger(
            'beforeDeleteUser',
            $this,
            array(
                'deleteUser' => $deleteUser,
                'deletableUser' => $deletableUser
            ),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            return $results->last();
        }

        /* @event deleteUser */
        $results = $this->getEventManager()->trigger(
            'deleteUser',
            $this,
            array(
                'deleteUser' => $deleteUser,
                'deletableUser' => $deletableUser
            ),
            function ($result) {
                return !$result->isSuccess();
            }
        );

        if ($results->stopped()) {

            $result = $results->last();
            $this->getEventManager()->trigger(
                'deleteUserFail',
                $this,
                array('result' => $result)
            );

            return $result;
        }

        $result = new Result($deletableUser);

        /* @event deleteUserSuccess */
        $this->getEventManager()->trigger(
            'deleteUserSuccess',
            $this,
            array('result' => $result)
        );

        return $result;
    }

} 