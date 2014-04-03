<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Entity;


/**
 * Interface UserRoleInterface
 *
 * @package RcmUser\User\Entity
 */
interface UserRoleInterface
{
    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $roleId
     */
    public function setRoleId($roleId);

    /**
     * @return int
     */
    public function getRoleId();

    /**
     * @param int $userId
     */
    public function setUserId($userId);

    /**
     * @return int
     */
    public function getUserId();
} 