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


use RcmUser\Acl\Entity\AclRole;
use RcmUser\Acl\Entity\AclRule;

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
     * @return Result
     */
    public function fetchAll();

    /**
     * fetchByRole
     *
     * @param mixed $roleId role id
     *
     * @return Result
     */
    public function fetchByRole($roleId);

    /**
     * fetchByRule
     *
     * @param AclRule $rule rule
     *
     * @return Result
     */
    public function fetchByRule($rule);

    /**
     * fetchByResource
     *
     * @param string $resource resource
     *
     * @return mixed
     */
    public function fetchByResource($resource);

    /**
     * create
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function create(AclRule $aclRule);

    /**
     * read
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function read(AclRule $aclRule);

    /**
     * update
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function update(AclRule $aclRule);

    /**
     * delete
     *
     * @param AclRule $aclRule acl rule
     *
     * @return Result
     */
    public function delete(AclRule $aclRule);
} 