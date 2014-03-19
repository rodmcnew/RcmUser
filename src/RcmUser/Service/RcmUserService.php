<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Service;

use Aws\CloudFront\Exception\Exception;
use RcmUser\User\Entity\AbstractUser;
use RcmUser\User\Entity\UserInterface;
use ZfcUser\Service\User;

class RcmUserService extends User
{
    protected $dbUserStorage;
    protected $sessionUserStorage;

    public function getUser($uuid = null)
    {
        $user = null;

        if ($uuid !== null) {

            // @todo Need storage to have uuid
            $user = $this->sessionUserStorage->read();

            if (!empty($user)) {

                return $user;
            }

            $user = $this->readUser($uuid);
        }

        if (empty($user)) {

            $user = $this->buildNewUser();
        }

        return $user;
    }

    public function saveUser($user)
    {

        if ($user->isSaved()) {

            return $this->updateUser($user);
        }

        return $this->createUser($user);
    }

    /////////////////////////////////////////
    public function getCurrentUser()
    {
        // check session
    }

    public function getUserAccess($user, $permisions)
    {
    }

    public function getCurrentUserAccess($permisionS)
    {
        // check session
    }

    public function getUserProperty($user, $propertyNameSpace = array())
    {
    }

    public function getCurrentUserProperty($propertyNameSpace = array())
    {
        // check session
    }

    public function readUser($uuid)
    {
        // @event pre
        $user = $this->dbUserStorage->read();

        if (!empty($user)) {

            $user->setSaved(true);
        }
        // @event post

        return $user;
    }


    public function createUser(AbstractUser $user)
    {
        $uuid = $user->getUuid();

        if (empty($uuid)) {

            $user->setUuid($this->buildUuid());
        }

        // @event pre
        $this->dbUserStorage->write($user);
        $newuser = $this->readUser($user->getUuid());
        // @event post

        return $newuser;

    }

    public function updateUser(AbstractUser $user)
    {
        $uuid = $user->getUuid();
        $saved = $user->getSaved();

        if (empty($uuid) || $saved == false) {

            throw new Exception('Uuid not set or user was never saved.');
        }

        // @event pre
        $this->dbUserStorage->write($user);
        $updateduser = $this->readUser($user->getUuid());
        // @event post

        return $updateduser;
    }

    public function deleteUser(AbstractUser $user)
    {
        $uuid = $user->getUuid();
        $saved = $user->getSaved();

        if (empty($uuid) || $saved == false) {

            throw new Exception('Uuid not set or user was never saved.');
        }

        // @event pre
        $this->dbUserStorage->clear();
        $unsavedUser = new AbstractUser();
        $unsavedUser->setUuid($uuid);
        $unsavedUser->setSaved(false);
        // @event post

        return $unsavedUser;
    }

    public function buildNewUser(){

        $user = new AbstractUser();
        $user->setUuid($this->buildUuid());
        $user->setSaved(false);

        return $user;
    }

    public function buildUuid()
    {

        return $this->guidv4();
    }

    /////////// UTILITY
    protected function guidv4()
    {
        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0010
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

} 