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

/**
 * Interface DataMapperInterface
 *
 * @package RcmUser\Model\User
 */
interface DataMapperInterface
{
    const ID_FIELD = 'id';
    const USERNAME_FIELD = 'username';

    /**
     * @param $id
     *
     * @return UserInterface | Exception
     */
    public function fetchById($id);

    /**
     * @param $id
     *
     * @return UserInterface | Exception
     */
    public function fetchByUsername($id);

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function create(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function read(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function update(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function delete(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    //public function disable(UserInterface $user);

} 