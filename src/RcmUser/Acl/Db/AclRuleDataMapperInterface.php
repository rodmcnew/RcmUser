<?php
/**
 * AclRuleDataMapperInterface.php
 *
 * AclRuleDataMapperInterface
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

use
    RcmUser\Acl\Entity\AclRule;

/**
 * Interface AclRuleDataMapperInterface
 *
 * AclRuleDataMapperInterface Interface
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
interface AclRuleDataMapperInterface
{

    /**
     * fetchAll
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    array (
     *       1 => RcmUser\Acl\Entity\AclRule
     *    )
     *
     *    -- fail
     *    array()
     *
     * @return Result
     */
    public function fetchAll();

    /**
     * fetchByRole
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    array (
     *       0 => RcmUser\Acl\Entity\AclRule
     *    )
     *
     *    -- fail
     *    array()
     *
     * @param mixed $roleId role id
     *
     * @return Result
     */
    public function fetchByRole($roleId);

    /**
     * fetchByRule
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    array (
     *       0 => RcmUser\Acl\Entity\AclRule
     *    )
     *
     *    -- fail
     *    array()
     *
     * @param AclRule $rule rule
     *
     * @return Result
     */
    public function fetchByRule($rule);

    /**
     * fetchByResource
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    array (
     *       1 => RcmUser\Acl\Entity\AclRule
     *    )
     *
     *    -- fail
     *    array()
     *
     * @param string $resourceId resourceId
     *
     * @return Result
     */
    public function fetchByResource($resourceId);

    /**
     * create
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    RcmUser\Acl\Entity\AclRule
     *
     *    -- fail
     *    null
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function create(AclRule $aclRule);

    /**
     * read
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    RcmUser\Acl\Entity\AclRule
     *
     *    -- fail
     *    null
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function read(AclRule $aclRule);

    /**
     * update
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    RcmUser\Acl\Entity\AclRule
     *
     *    -- fail
     *    null
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function update(AclRule $aclRule);

    /**
     * delete
     *
     * RETURN DATA FORMAT:
     *
     *    -- success
     *    null
     *
     *    -- fail
     *    null
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function delete(AclRule $aclRule);
}
