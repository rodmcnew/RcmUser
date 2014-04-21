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
     * @param User $user user
     *
     * @return Result
     */
    public function create(User $user);

    /**
     * read
     *
     * @param User $user user
     *
     * @return Result
     */
    public function read(User $user);

    /**
     * update
     *
     * @param User $user user
     *
     * @return Result
     */
    public function update(User $user);

    /**
     * delete
     *
     * @param User $user user
     *
     * @return mixed Result
     */
    public function delete(User $user);
} 