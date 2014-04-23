<?php
/**
 * UserDataMapperInterface.php
 *
 * UserDataMapperInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Db;


use RcmUser\User\Entity\User;
use RcmUser\User\Result;

/**
 * Interface UserDataMapperInterface
 *
 * UserDataMapperInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface UserDataMapperInterface
{
    const ID_FIELD = 'id';
    const USERNAME_FIELD = 'username';

    /**
     * fetchById
     *
     * @param mixed $id id
     *
     * @return Result
     */
    public function fetchById($id);

    /**
     * fetchByUsername
     *
     * @param string $username username
     *
     * @return Result
     */
    public function fetchByUsername($username);

    /**
     * create
     *
     * @param User $newUser
     * @param User $creatableUser
     *
     * @return mixed
     */
    public function create(User $newUser, User $creatableUser);

    /**
     * read
     *
     * @param User $readUser
     * @param User $readableUser
     *
     * @return mixed
     */
    public function read(User $readUser, User $readableUser);

    /**
     * update
     *
     * @param User $updatedUser
     * @param User $updatableUser
     * @param User $existingUser
     *
     * @return mixed
     */
    public function update(User $updatedUser, User $updatableUser, User $existingUser);

    /**
     * delete
     *
     * @param User $deleteUser
     * @param User $deletableUser
     *
     * @return mixed
     */
    public function delete(User $deleteUser, User $deletableUser);
} 