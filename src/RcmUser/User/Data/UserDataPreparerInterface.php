<?php
/**
 * UserDataPreparerInterface.php
 *
 * UserDataPreparerInterface
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
 * Interface UserDataPreparerInterface
 *
 * UserDataPreparerInterface
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
interface UserDataPreparerInterface
{

    /**
     * prepareUserCreate
     *
     * @param User $newUser      newUser
     * @param User $userToCreate userToCreate
     *
     * @return Result
     */
    public function prepareUserCreate(User $newUser, User $userToCreate);

    /**
     * prepareUserUpdate
     *
     * @param User $updatedUser   updatedUser
     * @param User $updatableUser updatableUser
     *
     * @return Result
     */
    public function prepareUserUpdate(User $updatedUser, User $updatableUser);
} 