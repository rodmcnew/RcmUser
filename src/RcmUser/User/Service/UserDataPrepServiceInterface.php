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

interface UserDataPrepServiceInterface
{

    public function prepareUserCreate(User $userToCreate);

    public function prepareUserUpdate(User $updatedUser, User $existingUser);

    public function isValidCredential(User $credentialUser, User $existingUser);
} 