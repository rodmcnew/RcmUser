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
    /**
     * fetchById
     *
     * @param mixed $id id
     *
     * @return \RcmUser\User\Result
     */
    public function fetchById(
        $id
    );

    /**
     * fetchByUsername
     *
     * @param string $username username
     *
     * @return \RcmUser\User\Result
     */
    public function fetchByUsername(
        $username
    );

    /**
     * create
     *
     * @param User $requestUser  User new data (AKA request)
     * @param User $responseUser User new data prepared (VIA Event Listeners)
     *
     * @return \RcmUser\User\Result Result::user = $responseUser or null
     */
    public function create(
        User $requestUser,
        User $responseUser
    );

    /**
     * read
     *
     * @param User $requestUser  User read data (AKA request)
     * @param User $responseUser User read data prepared (VIA Event Listeners)
     *
     * @return \RcmUser\User\Result Result::user = $responseUser or null
     */
    public function read(
        User $requestUser,
        User $responseUser
    );

    /**
     * update
     *
     * @param User $requestUser  User update data (AKA request)
     * @param User $responseUser User update data prepared (VIA Event Listeners)
     * @param User $existingUser User that currently exists
     *
     * @return \RcmUser\User\Result Result::user = $responseUser or null
     */
    public function update(
        User $requestUser,
        User $responseUser,
        User $existingUser
    );

    /**
     * delete
     *
     * @param User $requestUser  User delete data (AKA request)
     * @param User $responseUser User delete data prepared (VIA Event Listeners)
     *
     * @return \RcmUser\User\Result Result::user = $responseUser or null
     */
    public function delete(
        User $requestUser,
        User $responseUser
    );
} 