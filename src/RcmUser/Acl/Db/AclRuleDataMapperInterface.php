<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Db;


use RcmUser\Acl\Entity\AclRole;
use RcmUser\Acl\Entity\AclRule;

/**
 * Interface AclRuleDataMapperInterface
 *
 * @package RcmUser\Acl\Db
 */
interface AclRuleDataMapperInterface {


    /**
     * @return Result
     */
    public function fetchAll();

    /**
     * @param int $id
     *
     * @return Result
     */
    public function fetchById($id);

    /**
     * @param $parentId
     *
     * @return Result
     */
    public function fetchByParentId($parentId);

    /**
     * @param $roleId
     *
     * @return Result
     */
    public function fetchByRole($roleId);

    /**
     * @param string $rule
     *
     * @return Result
     */
    public function fetchByRule($rule);

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function create(AclRule $aclRule);

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function read(AclRule $aclRule);

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function update(AclRule $aclRule);

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function delete(AclRule $aclRule);
} 