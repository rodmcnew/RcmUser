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

interface UserDataPreparerInterface
{

    /**
     * @param User $newUser
     * @param User $userToCreate
     *
     * @return Result
     */
    public function prepareUserCreate( User $newUser, User $userToCreate);

    /**
     * @param User $updatedUser
     * @param User $updatableUser
     *
     * @return Result
     */
    public function prepareUserUpdate(User $updatedUser, User $updatableUser);
} 