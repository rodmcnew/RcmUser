<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\User\Db;


use RcmUser\Model\User\Entity\UserInterface;
use RcmUser\Model\User\Result;

/**
 * Interface UserDataMapperInterface
 *
 * @package RcmUser\Model\User
 */
interface UserDataMapperInterface
{
    const ID_FIELD = 'id';
    const USERNAME_FIELD = 'username';

    /**
     * @param $id
     *
     * @return RcmUser\Model\User\Result
     */
    public function fetchById($id);

    /**
     * @param $username
     *
     * @return RcmUser\Model\User\Result
     */
    public function fetchByUsername($username);

    /**
     * @param UserInterface $user
     *
     * @return RcmUser\Model\User\Result
     */
    public function create(UserInterface $user);

    /**
     * This will read the user from Id or Username. Id will get priority if it is set.
     * @param UserInterface $user
     *
     * @return RcmUser\Model\User\Result
     */
    public function read(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return RcmUser\Model\User\Result
     */
    public function update(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return RcmUser\Model\User\Result
     */
    public function delete(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return RcmUser\Model\User\Result
     */
    //public function disable(UserInterface $user);

} 