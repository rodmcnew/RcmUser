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

interface UserValidatorInterface {

    /**
     * @param User $updatedUser
     * @param User $updatableUser
     *
     * @return Result
     */
    public function validateUpdateUser(User $updatedUser, User $updatableUser);

    /**
     * @param User $newUser
     * @param User $creatableUser
     *
     * @return mixed
     */
    public function validateCreateUser(User $newUser, User $creatableUser);

} 