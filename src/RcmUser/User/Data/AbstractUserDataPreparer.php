<?php
/**
 * AbstractUserDataPreparer.php
 *
 * AbstractUserDataPreparer
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
use RcmUser\User\Result;
use Zend\Crypt\Password\PasswordInterface;

/**
 * Class AbstractUserDataPreparer
 *
 * AbstractUserDataPreparer
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
class AbstractUserDataPreparer implements UserDataPreparerInterface
{

    /**
     * prepareUserCreate
     *
     * @param User $newUser       newUser
     * @param User $creatableUser creatableUser
     *
     * @return Result
     */
    public function prepareUserCreate(User $newUser, User $creatableUser)
    {
        return new Result($creatableUser);
    }

    /**
     * prepareUserUpdate
     *
     * @param User $updatedUser   updatedUser
     * @param User $updatableUser updatableUser
     * @param User $existingUser $existingUser
     *
     * @return Result
     */
    public function prepareUserUpdate(
        User $updatedUser,
        User $updatableUser,
        User $existingUser
    ) {
        return new Result($updatableUser);
    }
} 