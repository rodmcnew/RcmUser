<?php
/**
 * AclRoleDataMapperInterface.php
 *
 * AclRoleDataMapperInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Db;


use RcmUser\Acl\Entity\AclRole;

/**
 * Interface AclRoleDataMapperInterface
 *
 * AclRoleDataMapperInterface Interface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface AclRoleDataMapperInterface
{

    /**
     * fetchAll
     *
     * @return Result
     */
    public function fetchAll();

    /**
     * fetchById
     *
     * @param int $id id
     *
     * @return Result
     */
    public function fetchById($id);

    /**
     * fetchByParentId
     *
     * @param int $parentId parent id
     *
     * @return Result
     */
    public function fetchByParentId($parentId);

    /**
     * fetchByRoleIdentity
     *
     * @param string $roleIdentity role identity
     *
     * @return Result
     */
    public function fetchByRoleIdentity($roleIdentity);

    /**
     * create
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     */
    public function create(AclRole $aclRole);

    /**
     * read
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     */
    public function read(AclRole $aclRole);

    /**
     * update
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     */
    public function update(AclRole $aclRole);

    /**
     * delete
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     */
    public function delete(AclRole $aclRole);
} 