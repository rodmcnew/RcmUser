<?php
/**
 * AbstractUserDataMapper.php
 *
 * AbstractUserDataMapper
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */
namespace RcmUser\User\Db;


use RcmUser\User\Data\UserDataPreparerInterface;
use RcmUser\User\Data\UserValidatorInterface;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;

/**
 * Class AbstractUserDataMapper
 *
 * AbstractUserDataMapper
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractUserDataMapper implements UserDataMapperInterface
{
    /**
     * @var string
     */
    protected $defaultUserState = User::STATE_DISABLED;

    /**
     * @var UserDataPreparerInterface
     */
    protected $userDataPreparer;

    /**
     * @var UserValidatorInterface
     */
    protected $userValidator;

    /**
     * setUserDataPreparer
     *
     * @param UserDataPreparerInterface $userDataPreparer userDataPreparer
     *
     * @return void
     */
    public function setUserDataPreparer(UserDataPreparerInterface $userDataPreparer)
    {
        $this->userDataPreparer = $userDataPreparer;
    }

    /**
     * getUserDataPreparer
     *
     * @return UserDataPreparerInterface
     */
    public function getUserDataPreparer()
    {
        return $this->userDataPreparer;
    }

    /**
     * setUserValidator
     *
     * @param UserValidatorInterface $userValidator userValidator
     *
     * @return void
     */
    public function setUserValidator(UserValidatorInterface $userValidator)
    {
        $this->userValidator = $userValidator;
    }

    /**
     * getUserValidator
     *
     * @return UserValidatorInterface
     */
    public function getUserValidator()
    {
        return $this->userValidator;
    }

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
     * fetchById
     *
     * @param mixed $id id
     *
     * @return Result
     */
    public function fetchById($id)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be found by id.');
    }

    /**
     * fetchByUsername
     *
     * @param string $username username
     *
     * @return Result
     */
    public function fetchByUsername($username)
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'User cannot be found by username.'
        );
    }

    /**
     * create
     *
     * @param User $requestUser  requestUser
     * @param User $responseUser responseUser
     *
     * @return Result
     */
    public function create(User $requestUser, User $responseUser)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be created.');
    }

    /**
     * read
     *
     * @param User $requestUser  requestUser
     * @param User $responseUser responseUser
     *
     * @return Result
     */
    public function read(User $requestUser, User $responseUser)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be read.');
    }

    /**
     * update
     *
     * @param User $requestUser  requestUser
     * @param User $responseUser responseUser
     * @param User $existingUser existingUser
     *
     * @return mixed|Result
     */
    public function update(User $requestUser, User $responseUser, User $existingUser)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be updated.');
    }

    /**
     * delete
     *
     * @param User $requestUser  requestUser
     * @param User $responseUser responseUser
     *
     * @return mixed|Result
     */
    public function delete(User $requestUser, User $responseUser)
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be deleted.');
    }

    /**
     * canUpdate
     *
     * @param User $user user
     *
     * @return bool
     */
    public function canUpdate(User $user)
    {
        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        return true;
    }
} 