<?php
/**
 * UserValidatorInterface.php
 *
 * UserValidatorInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Data;

use RcmUser\User\Entity\User;

/**
 * Interface UserValidatorInterface
 *
 * UserValidatorInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Data
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface UserValidatorInterface
{
    /**
     * validateCreateUser
     *
     * @param User $newUser       newUser
     * @param User $creatableUser creatableUser
     *
     * @return Result
     */
    public function validateCreateUser(User $newUser, User $creatableUser);

    /**
     * validateUpdateUser
     *
     * @param User $updatedUser   updatedUser
     * @param User $updatableUser updatableUser
     * @param User $existingUser  existingUser
     *
     * @return Result
     */
    public function validateUpdateUser(User $updatedUser, User $updatableUser, User $existingUser);

} 