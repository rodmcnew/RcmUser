<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Acl\Db;


use RcmUser\Model\Acl\Entity\AclRole;

/**
 * Interface AclRoleDataMapperInterface
 *
 * @package RcmUser\Model\Acl\Db
 */
interface AclRoleDataMapperInterface {


    /**
     * @return array
     */
    public function fetchAll();

    /**
     * @param int $id
     *
     * @return AclRole
     */
    public function fetchById($id);

    /**
     * @param $parentId
     *
     * @return array
     */
    public function fetchByParentId($parentId);

    /**
     * @param $roleIdentity
     *
     * @return AclRole
     */
    public function fetchByRoleIdentity($roleIdentity);

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function create(AclRole $aclRole);

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function read(AclRole $aclRole);

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function update(AclRole $aclRole);

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function delete(AclRole $aclRole);
} 