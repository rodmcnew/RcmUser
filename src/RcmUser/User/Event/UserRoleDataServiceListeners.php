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


use RcmUser\User\Db\UserRolesDataMapper;
use RcmUser\User\Db\UserRolesDataMapperInterface;
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;
use RcmUser\User\Result;
use RcmUser\User\Service\UserRolePropertyService;

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
     * @var int
     */
    protected $priority = 1;
    /**
     * @var array
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
     * @var UserRolePropertyService
     */
    protected $userRolePropertyService;

    /**
     * setUserRolePropertyService
     *
     * @param UserRolePropertyService $userRolePropertyService
     *
     * @return void
     */
    public function setUserRolePropertyService(UserRolePropertyService $userRolePropertyService)
    {
        $this->userRolePropertyService = $userRolePropertyService;
    }

    /**
     * getUserRolePropertyService
     *
     * @return UserRolePropertyService
     */
    public function getUserRolePropertyService()
    {
        return $this->userRolePropertyService;
    }

    /**
     * getUserRolesDataMapper
     *
     * @return UserRolesDataMapperInterface
     */
    public function getUserRolesDataMapper()
    {
        return $this->userRolePropertyService->getUserRolesDataMapper();
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
        $responseUser = $e->getParam('responseUser');

        $userRoleProperty = $this->buildUserRoleProperty(
            $this->getDefaultRoles($responseUser)
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

        if ($result->isSuccess()) {

            $responseUser = $result->getUser();

            $currentRoleProperty = $responseUser->getProperty(
                $this->getUserPropertyKey()
            );

            if (empty($currentRoleProperty)) {

                $newUserRoleProperty = $this->buildUserRoleProperty(
                    $this->getDefaultRoles($responseUser)
                );

                $responseUser->setProperty(
                    $this->getUserPropertyKey(),
                    $newUserRoleProperty
                );
            }

            /** @var $currentRoleProperty \RcmUser\User\Entity\UserRoleProperty */
            $currentRoleProperty = $responseUser->getProperty(
                $this->getUserPropertyKey()
            );

            $aclResult = $this->getUserRolesDataMapper()->create(
                $responseUser,
                $currentRoleProperty->getRoles()
            );

            if (!$aclResult->isSuccess()) {

                return $aclResult;
            }

            $newUserRoleProperty = $this->buildUserRoleProperty(
                $aclResult->getData()
            );

            $responseUser->setProperty(
                $this->getUserPropertyKey(),
                $newUserRoleProperty
            );

            return new Result($responseUser, Result::CODE_SUCCESS);
        }

        return $result;
    }

    /**
     * onReadUserSuccess
     *
     * @param Event $e e
     *
     * @return \RcmUser\User\Result|void
     */
    public function onReadUserSuccess($e)
    {
        $result = $e->getParam('result');
        if ($result->isSuccess()) {

            $responseUser = $result->getUser();

            $roles = $this->getDefaultRoles($responseUser);

            $readResult = $this->getUserRolesDataMapper()->read($responseUser);

            if ($readResult->isSuccess()) {

                $roles = $readResult->getData();
            }

            $userRoleProperty = $this->buildUserRoleProperty($roles);

            $responseUser->setProperty(
                $this->getUserPropertyKey(),
                $userRoleProperty
            );

            return new Result($responseUser, Result::CODE_SUCCESS);
        }

        return $result;
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

        if ($result->isSuccess()) {

            $responseUser = $result->getUser();

            $currentRoles = $responseUser->getProperty(
                $this->getUserPropertyKey(),
                null
            );

            if ($currentRoles === null) {

                $userRoleProperty = $this->buildUserRoleProperty(
                    $this->getDefaultRoles($responseUser)
                );

                $responseUser->setProperty(
                    $this->getUserPropertyKey(),
                    $userRoleProperty
                );
            }

            $aclResult = $this->getUserRolesDataMapper()->update(
                $responseUser,
                $responseUser->getProperty(
                    $this->getUserPropertyKey(),
                    array()
                )
            );

            if (!$aclResult->isSuccess()) {

                return $aclResult;
            }

            $userRoleProperty = $this->buildUserRoleProperty(
                $aclResult->getData()
            );

            $responseUser->setProperty(
                $this->getUserPropertyKey(),
                $userRoleProperty
            );

            return new Result($responseUser, Result::CODE_SUCCESS);
        }

        return $result;
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

        if ($result->isSuccess()) {

            $responseUser = $result->getUser();

            $aclResult = $this->getUserRolesDataMapper()->delete(
                $responseUser,
                $responseUser->getProperty(
                    $this->getUserPropertyKey(),
                    array()
                )
            );

            if (!$aclResult->isSuccess()) {

                return $aclResult;
            }

            $userRoleProperty = $this->buildUserRoleProperty(
                $this->getDefaultRoleIdentities()
            );

            $responseUser->setProperty(
                $this->getUserPropertyKey(),
                $userRoleProperty
            );

            return new Result($responseUser, Result::CODE_SUCCESS);
        }

        return $result;
    }

} 