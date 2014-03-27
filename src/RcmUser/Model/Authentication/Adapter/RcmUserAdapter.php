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


use RcmUser\Model\Config\Config;
use RcmUser\Model\User\Entity\AbstractUser;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

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
    protected $user;

    /**
     * @var
     */
    protected $userDataMapper;

    /**
     * @var
     */
    protected $encryptor;

    /**
     * @param PasswordInterface $encryptor
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
     * @param DataMapperInterface $userDataMapper
     */
    public function setUserDataMapper(DataMapperInterface $userDataMapper)
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
        //@todo can the identity be the user object?
        $this->setIdentity($username);
        $password = $user->getPassword();
        $this->setCredential($password);

        if ($username === null || $password === null) {

            return new Result(
                Result::FAILURE_IDENTITY_AMBIGUOUS,
                $username,
                array('User credentials required.')
            );
        }

        $existingUserResult = $this->getUserDataMapper()->fetchByUsername($username);

        if (!$existingUserResult->isSuccess()) {

            // ERROR
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                $username,
                $existingUserResult->getMessages()
            );
        }

        $existingUser = $existingUserResult->getUser();
        $existingHash = $existingUser->getPassword();

        $credential = $user->getPassword();

        // @event pre
        $isValid = $this->getEncryptor()->verify($credential, $existingHash);
        if ($isValid) {

            $result = new Result(
                Result::SUCCESS,
                $username,
                array()
            );
            //new Result($existingUser);
        } else {
            $result =  new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                $username,
                array('User credential invalid.')
            );
        }

        // @event post

        return $result;
    }
} 