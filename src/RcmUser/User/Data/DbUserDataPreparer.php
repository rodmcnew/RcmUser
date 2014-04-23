<?php
/**
 * DbUserDataPreparer.php
 *
 * DbUserDataPreparer
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Data;


use RcmUser\User\Db\UserDataMapperInterface;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use Zend\Crypt\Password\PasswordInterface;

/**
 * Class DbUserDataPreparer
 *
 * DbUserDataPreparer
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class DbUserDataPreparer implements UserDataPreparerInterface
{

    /**
     * @var UserDataMapperInterface $userDataMapper
     */
    protected $userDataMapper;

    /**
     * @var PasswordInterface $encryptor
     */
    protected $encryptor;

    /**
     * setUserDataMapper
     *
     * @param UserDataMapperInterface $userDataMapper userDataMapper
     *
     * @return void
     */
    public function setUserDataMapper(UserDataMapperInterface $userDataMapper)
    {
        $this->userDataMapper = $userDataMapper;
    }

    /**
     * getUserDataMapper
     *
     * @return UserDataMapperInterface
     */
    public function getUserDataMapper()
    {
        return $this->userDataMapper;
    }

    /**
     * setEncryptor
     *
     * @param PasswordInterface $encryptor encryptor
     *
     * @return void
     */
    public function setEncryptor(PasswordInterface $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * getEncryptor
     *
     * @return PasswordInterface
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /**
     * prepareUserCreate
     *
     * @param User $newUser       newUser
     * @param User $creatableUser creatableUser
     *
     * @return Result
     */
    public function prepareUserCreate(User $newUser, User $creatableUser)
    {

        // make sure no duplicates
        $dupUser = $this->getUserDataMapper()->fetchByUsername(
            $newUser->getUsername()
        );

        if ($dupUser->isSuccess()) {

            // ERROR - user exists
            return new Result(
                null,
                Result::CODE_FAIL,
                'User could not be prepared, duplicate username.'
            );
        }

        $creatableUser->setId($this->buildId());
        $creatableUser->setPassword(
            $this->getEncryptor()->create($newUser->getPassword())
        );
        if (empty($newUser->getState())) {
            $creatableUser->setState(User::STATE_DISABLED);
        }

        return new Result($creatableUser);
    }

    /**
     * prepareUserUpdate
     *
     * @param User $updatedUser   updatedUser
     * @param User $updatableUser updatableUser
     * @param User $existingUser  existingUser
     *
     * @return Result
     */
    public function prepareUserUpdate(
        User $updatedUser,
        User $updatableUser,
        User $existingUser
    ) {
        // USERNAME CHECKS
        $updatedUsername = $updatedUser->getUsername();
        $existingUserName = $existingUser->getUsername();

        // if username changed:
        if ($existingUserName !== $updatedUsername) {

            // make sure no duplicates
            $dupUser = $this->getUserDataMapper()->fetchByUsername($updatedUsername);

            if ($dupUser->isSuccess()) {

                // ERROR - user exists
                return new Result(
                    null,
                    Result::CODE_FAIL,
                    'User could not be prepared, duplicate username.'
                );
            }

            $updatableUser->setUsername($updatedUsername);
        }

        // PASSWORD CHECKS
        $updatedPassword = $updatedUser->getPassword();
        $existingPassword = $existingUser->getPassword();
        //$hashedPassword = $existingPassword;

        // if password changed
        if ($existingPassword !== $updatedPassword) {

            $hashedPassword = $this->getEncryptor()->create($updatedPassword);
            $updatableUser->setPassword($hashedPassword);
        }

        // STATE
        $updatedState = $updatedUser->getState();
        $existingState = $existingUser->getState();

        if ($updatedState !== $existingState) {

            $updatableUser->setState($updatedState);
        }

        return new Result($updatableUser);
    }

    /**
     * isValidCredential
     *
     * @param User $credentialUser credentialUser
     * @param User $existingUser   existingUser
     *
     * @return bool
     */
    public function isValidCredential(User $credentialUser, User $existingUser)
    {

        $existingHash = $existingUser->getPassword();

        $credential = $credentialUser->getPassword();

        $isValid = $this->getEncryptor()->verify($credential, $existingHash);

        return $isValid;
    }

    /**
     * buildId
     *
     * @return string
     */
    public function buildId()
    {

        return $this->guidv4();
    }

    /**
     * guidv4: UUID generation
     *
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