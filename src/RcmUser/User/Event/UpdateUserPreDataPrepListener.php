<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Event;


use RcmUser\Event\AbstractListener;
use RcmUser\User\Result;

class UpdateUserPrePrepListener extends AbstractListener {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\User\Service\UserDataService';
    protected $event = 'updateUser.pre';
    protected $priority = 100;

    /**
     * @param $e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        $target = $e->getTarget();
        $resultUser = $e->getParam('resultUser');
        $updatedUser =  $e->getParam('updatedUser');


        // USERNAME CHECKS
        $updatedUsername = $updatedUser->getUsername();
        $existingUserName = $resultUser->getUsername();

        // sync null
        if ($updatedUsername !== null) {

            // if username changed:
            if ($existingUserName !== $updatedUsername) {

                // make sure no duplicates
                $dupUser = $target->getUserDataMapper()->fetchByUsername($updatedUsername);

                if ($dupUser->isSuccess()) {

                    // ERROR - user exists
                    return new Result(null, Result::CODE_FAIL, 'User could not be prepared, duplicate username.');
                }

                $resultUser->setUsername($updatedUsername);
            }
        }

        // PASSWORD CHECKS
        $updatedPassword = $updatedUser->getPassword();
        $existingPassword = $resultUser->getPassword();
        $hashedPassword = $existingPassword;
        // sync null
        if ($updatedPassword !== null) {
            // if password changed
            if ($existingPassword !== $updatedPassword) {
                // plain text
                $resultUser->setPassword($updatedPassword);
                $hashedPassword = $target->getUserDataPrepService()->getEncryptor()->create($updatedPassword);
            }
        }

        $resultUser->setPassword($hashedPassword);

        return new Result($resultUser);
    }
} 