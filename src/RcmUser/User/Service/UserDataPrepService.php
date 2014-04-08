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


use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use Zend\Crypt\Password\PasswordInterface;

class UserDataPrepService implements UserDataPrepServiceInterface
{

    protected $userDataMapper;

    protected $encryptor;

    /**
     * @param mixed $userDataMapper
     */
    public function setUserDataMapper($userDataMapper)
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
     * @param mixed $encryptor
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

    public function prepareUserCreate(User $newUser, User $creatableUser)
    {

        $creatableUser->setId($this->buildId());
        $creatableUser->setPassword($this->getEncryptor()->create($newUser->getPassword()));

        return new Result($creatableUser);
    }

    public function prepareUserUpdate(User $updatedUser, User $existingUser)
    {

        // USERNAME CHECKS
        $updatedUsername = $updatedUser->getUsername();
        $existingUserName = $existingUser->getUsername();

        // sync null
        if ($updatedUsername !== null) {

            // if username changed:
            if ($existingUserName !== $updatedUsername) {

                // make sure no duplicates
                $dupUser = $this->getUserDataMapper()->fetchByUsername($updatedUsername);

                if ($dupUser->isSuccess()) {

                    // ERROR - user exists
                    return new Result(null, Result::CODE_FAIL, 'User could not be prepared, duplicate username.');
                }

                $existingUser->setUsername($updatedUsername);
            }
        }

        // PASSWORD CHECKS
        $updatedPassword = $updatedUser->getPassword();
        $existingPassword = $existingUser->getPassword();
        $hashedPassword = $existingPassword;
        // sync null
        if ($updatedPassword !== null) {
            // if password changed
            if ($existingPassword !== $updatedPassword) {
                // plain text
                $existingUser->setPassword($updatedPassword);
                $hashedPassword = $this->getEncryptor()->create($updatedPassword);
            }
        }

        $existingUser->setPassword($hashedPassword);

        return new Result($existingUser);
    }

    public function isValidCredential(User $credentialUser, User $existingUser)
    {

        $existingHash = $existingUser->getPassword();

        $credential = $credentialUser->getPassword();

        $isValid = $this->getEncryptor()->verify($credential, $existingHash);

        return $isValid;
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