<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Data;


use RcmUser\User\Entity\User;
use RcmUser\User\Result;
use Zend\Crypt\Password\PasswordInterface;

class UserDataPreparer implements UserDataPreparerInterface
{

    public function prepareUserCreate(User $newUser, User $creatableUser)
    {

        return new Result($creatableUser);
    }

    public function prepareUserUpdate(User $updatedUser, User $updatableUser)
    {

        $updatableUser->populate($updatedUser);

        return new Result($updatableUser);
    }
} 