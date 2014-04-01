<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Authentication\Adapter;


use RcmUser\Model\User\Db\UserDataMapperInterface;
use RcmUser\Model\User\Entity\AbstractUser;
use RcmUser\Model\User\Entity\User;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\Crypt\Password\PasswordInterface;

/**
 * Class RcmUserAdapter
 *
 * @package RcmUser\Model\Authentication\Adapter
 */
class RcmUserAdapter extends AbstractAdapter
{
    /**
     * @var
     */
    protected $userDataService;

    /**
     * @var
     */
    protected $user;

    /**
     * @var bool
     * Force returned user to hide password, can cause issues is return object is meant to be saved.
     */
    protected $obfuscatePassword = true;

    /**
     * @param mixed $user
     */
    public function setUser(AbstractUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param boolean $obfuscatePassword
     */
    public function setObfuscatePassword($obfuscatePassword)
    {
        $this->obfuscatePassword = (boolean)$obfuscatePassword;
    }

    /**
     * @return boolean
     */
    public function getObfuscatePassword()
    {
        return $this->obfuscatePassword;
    }

    /**
     * @param mixed $userDataService
     */
    public function setUserDataService($userDataService)
    {
        $this->userDataService = $userDataService;
    }

    /**
     * @return mixed
     */
    public function getUserDataService()
    {
        return $this->userDataService;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *               If authentication cannot be performed
     */
    public function authenticate()
    {
        $user = $this->getUser();
        $username = $user->getUsername();
        $password = $user->getPassword();

        $this->setIdentity($user);
        $this->setCredential($password);

        if ($username === null || $password === null) {

            return new Result(
                Result::FAILURE_IDENTITY_AMBIGUOUS,
                null,
                array('User credentials required.')
            );
        }

        // We will remove id is set so that we only read from username, this will eliminate an incorrect id/username match in the object
        $user->setId(null);

        $existingUserResult = $this->getUserDataService()->readUser($user);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                $existingUserResult->getMessages()
            );
        }

        $existingUser = $existingUserResult->getUser();
        $existingHash = $existingUser->getPassword();

        $credential = $user->getPassword();

        $isValid = $this->getUserDataService()->getEncryptor()->verify($credential, $existingHash);
        if ($isValid) {

            if ($this->getObfuscatePassword()) {

                $existingUser->setPassword(AbstractUser::PASSWORD_OBFUSCATE);
            }

            $result = new Result(
                Result::SUCCESS,
                $existingUser,
                array()
            );
        } else {

            $result = new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                null,
                array('User credential invalid.')
            );
        }

        return $result;
    }
} 