<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\User\Event;


use RcmUser\Model\Event\AbstractListener;
use RcmUser\Model\User\Result;

class UpdateUserPreListener extends AbstractListener {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\Service\RcmUserDataService';
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
        $existingUser = $e->getParam('existingUser');
        $updatedUser =  $e->getParam('updatedUser');


        // USERNAME CHECKS
        $updatedUsername = $updatedUser->getUsername();
        $existingUserName = $existingUser->getUsername();

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
                $hashedPassword = $target->getEncryptor()->create($updatedPassword);
            }
        }

        // run validation rules
        $validateResult = $target->getUserValidatorService()->validateUser($existingUser);

        if (!$validateResult->isSuccess()) {

            return $validateResult;
        }

        // if valid:
        $existingUser->setPassword($hashedPassword);

        return new Result($existingUser);
    }
} 