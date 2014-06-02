<?php
/**
 * UserRoleDataServiceListeners.php
 *
 * UserRoleDataServiceListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Event;


use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;
use RcmUser\User\Result;
use RcmUser\User\Service\UserRoleService;

/**
 * UserRoleDataServiceListeners
 *
 * UserRoleDataServiceListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserRoleDataServiceListeners extends AbstractUserDataServiceListeners
{
    /**
     * @var int $priority
     */
    protected $priority = 1;
    /**
     * @var array $listenerMethods
     */
    protected $listenerMethods
        = array(
            'onBuildUser' => 'buildUser',

            'onBeforeCreateUser' => 'beforeCreateUser',
            //'onCreateUser' => 'createUser',
            //'onCreateUserFail' => 'createUserFail',
            'onCreateUserSuccess' => 'createUserSuccess',

            //'onBeforeReadUser' => 'beforeReadUser',
            //'onReadUser' => 'readUser',
            //'onReadUserFail' => 'readUserFail',
            'onReadUserSuccess' => 'readUserSuccess',

            'onBeforeUpdateUser' => 'beforeUpdateUser',
            //'onUpdateUser' => 'updateUser',
            //'onUpdateUserFail' => 'updateUserFail',
            'onUpdateUserSuccess' => 'updateUserSuccess',

            //'onBeforeDeleteUser' => 'beforeDeleteUser',
            //'onDeleteUser' => 'deleteUser',
            //'onDeleteUserFail' => 'deleteUserFail',
            'onDeleteUserSuccess' => 'deleteUserSuccess',
        );

    /**
     * @var UserRoleService $userRoleService
     */
    protected $userRoleService;

    /**
     * setUserRoleService
     *
     * @param UserRoleService $userRoleService
     *
     * @return void
     */
    public function setUserRoleService(UserRoleService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }

    /**
     * getUserRoleService
     *
     * @return UserRoleService
     */
    public function getUserRoleService()
    {
        return $this->userRoleService;
    }

    /**
     * getUserPropertyKey
     *
     * @return string
     */
    public function getUserPropertyKey()
    {
        return UserRoleProperty::PROPERTY_KEY;
    }

    /**
     * onBeforeCreateUser
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Result
     */
    public function onBeforeCreateUser($e)
    {
        $requestUser = $e->getParam('requestUser');
        $responseUser = $e->getParam('responseUser');

        /* VALIDATE */
        $aclRoles = $responseUser->getProperty(
            $this->getUserPropertyKey()
        );

        if (!empty($aclRoles)) {

            // @todo Validation logic here
            // make sure the role sent in is valid
        }

        return new Result($responseUser);
    }

    /**
     * onBuildUser
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Result
     */
    public function onBuildUser($e)
    {

        // $requestUser = $e->getParam('requestUser');
        /** @var User $responseUser */
        $responseUser = $e->getParam('responseUser');

        $userRoleProperty = $responseUser->getProperty(
            $this->getUserPropertyKey(),
            $this->buildValidUserRoleProperty($responseUser, array())
        );

        $responseUser->setProperty(
            $this->getUserPropertyKey(),
            $userRoleProperty
        );

        return new Result($responseUser);
    }

    /**
     * onCreateUserSuccess
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Result
     */
    public function onCreateUserSuccess($e)
    {
        $result = $e->getParam('result');

        if (!$result->isSuccess()) {

            return $result;
        }

        $responseUser = $result->getUser();

        /** @var $userRoleProperty \RcmUser\User\Entity\UserRoleProperty */
        $userRoleProperty = $responseUser->getProperty(
            $this->getUserPropertyKey(),
            $this->buildValidUserRoleProperty($responseUser, array())
        );

        $roles = $userRoleProperty->getRoles();

        if ($this->isDefaultRoles($roles)) {

            return new Result($responseUser, Result::CODE_SUCCESS);
        }

        $aclResult = $this->getUserRoleService()->createRoles(
            $responseUser,
            $roles
        );

        if (!$aclResult->isSuccess()) {

            return $aclResult;
        }

        $userRoleProperty->setRoles($aclResult->getData());

        $responseUser->setProperty(
            $this->getUserPropertyKey(),
            $userRoleProperty
        );

        return new Result($responseUser, Result::CODE_SUCCESS);

    }

    /**
     * onReadUserSuccess
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Result
     */
    public function onReadUserSuccess($e)
    {
        $result = $e->getParam('result');

        if (!$result->isSuccess()) {

            return $result;
        }

        $responseUser = $result->getUser();

        $readResult = $this->getUserRoleService()->readRoles($responseUser);

        if (!$readResult->isSuccess()) {

            return $readResult;
        }

        $roles = $readResult->getData();

        $userRoleProperty = $this->buildValidUserRoleProperty(
            $responseUser,
            $roles
        );

        $responseUser->setProperty(
            $this->getUserPropertyKey(),
            $userRoleProperty
        );

        return new Result($responseUser, Result::CODE_SUCCESS);
    }

    /**
     * onBeforeUpdateUser
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Result
     */
    public function onBeforeUpdateUser($e)
    {
        $requestUser = $e->getParam('requestUser');
        $responseUser = $e->getParam('responseUser');
        $existingUser = $e->getParam('existingUser');

        /* VALIDATE */
        $aclRoles = $responseUser->getProperty(
            $this->getUserPropertyKey()
        );

        if (!empty($aclRoles)) {

            // @todo Validation logic here
            // make sure the role sent in is valid
        }

        return new Result($responseUser);
    }

    /**
     * onUpdateUserSuccess
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Db\Result|Result
     */
    public function onUpdateUserSuccess($e)
    {
        $result = $e->getParam('result');

        if (!$result->isSuccess()) {

            return $result;
        }

        $responseUser = $result->getUser();

        /** @var $userRoleProperty \RcmUser\User\Entity\UserRoleProperty */
        $userRoleProperty = $responseUser->getProperty(
            $this->getUserPropertyKey(),
            $this->buildValidUserRoleProperty($responseUser, array())
        );

        $roles = $userRoleProperty->getRoles();

        if ($this->isDefaultRoles($roles)) {

            return new Result($responseUser, Result::CODE_SUCCESS);
        }

        // do update
        $updateResult = $this->getUserRoleService()->updateRoles(
            $responseUser,
            $userRoleProperty->getRoles()
        );

        if (!$updateResult->isSuccess()) {

            return $updateResult;
        }

        $userRoleProperty->setRoles($updateResult->getData());

        $responseUser->setProperty(
            $this->getUserPropertyKey(),
            $userRoleProperty
        );

        return new Result($responseUser, Result::CODE_SUCCESS);
    }

    /**
     * onDeleteUserSuccess
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Db\Result|Result
     */
    public function onDeleteUserSuccess($e)
    {
        $result = $e->getParam('result');

        if (!$result->isSuccess()) {

            return $result;
        }

        $responseUser = $result->getUser();

        /** @var $userRoleProperty \RcmUser\User\Entity\UserRoleProperty */
        $userRoleProperty = $responseUser->getProperty(
            $this->getUserPropertyKey(),
            $this->buildUserRoleProperty(array())
        );

        $aclResult = $this->getUserRoleService()->deleteRoles(
            $responseUser,
            $userRoleProperty->getRoles()
        );

        if (!$aclResult->isSuccess()) {

            return $aclResult;
        }

        $userRoleProperty = $responseUser->getProperty(
            $this->getUserPropertyKey(),
            $this->buildUserRoleProperty(array())
        );

        $userRoleProperty->setRoles(array());

        $responseUser->setProperty(
            $this->getUserPropertyKey(),
            $userRoleProperty
        );

        return new Result($responseUser, Result::CODE_SUCCESS);
    }

    /**
     * isDefaultRoles
     *
     * @param array $roles roles
     *
     * @return mixed
     */
    public function isDefaultRoles($roles)
    {
        return $this->getUserRoleService()->isDefaultRoles($roles);
    }

    /**
     * buildUserRoleProperty
     *
     * @param array $roles roles
     *
     * @return UserRoleProperty
     */
    public function buildUserRoleProperty($roles = array())
    {
        return $this->getUserRoleService()->buildUserRoleProperty($roles);
    }

    /**
     * buildValidUserRoleProperty
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return UserRoleProperty
     */
    public function buildValidUserRoleProperty(User $user, $roles = array())
    {
        return $this->getUserRoleService()->buildValidUserRoleProperty(
            $user,
            $roles
        );
    }

    /**
     * buildValidRoles
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return array
     */
    public function buildValidRoles(User $user, $roles = array())
    {
        return $this->getUserRoleService()->buildValidRoles(
            $user,
            $roles
        );
    }
} 