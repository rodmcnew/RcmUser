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

    /**
     * @param $id
     *
     * @return mixed
     */
    public function fetchById($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function fetchByUsername($id);

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function fetch(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function store(UserInterface $user);

} 