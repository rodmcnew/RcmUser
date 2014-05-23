<?php
/**
 * AclDataService.php
 *
 * AclDataService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Service;

use RcmUser\Acl\Db\AclRoleDataMapperInterface;
use RcmUser\Acl\Db\AclRuleDataMapperInterface;
use RcmUser\Acl\Entity\AclRole;
use RcmUser\Acl\Entity\AclRule;
use RcmUser\Config\Config;
use RcmUser\Result;


/**
 * AclDataService
 *
 * AclDataService @todo COMPLETE ME
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclDataService
{
    /**
     * @var Config $config
     */
    protected $config;

    /**
     * @var AclRoleDataMapperInterface
     */
    protected $aclRoleDataMapper;

    /**
     * @var AclRuleDataMapperInterface
     */
    protected $aclRuleDataMapper;

    /**
     * setConfig
     *
     * @param Config $config config
     *
     * @return void
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * getConfig
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * setAclRoleDataMapper
     *
     * @param AclRoleDataMapperInterface $aclRoleDataMapper aclRoleDataMapper
     *
     * @return void
     */
    public function setAclRoleDataMapper(
        AclRoleDataMapperInterface $aclRoleDataMapper
    ) {
        $this->aclRoleDataMapper = $aclRoleDataMapper;
    }

    /**
     * getAclRoleDataMapper
     *
     * @return AclRoleDataMapperInterface
     */
    public function getAclRoleDataMapper()
    {
        return $this->aclRoleDataMapper;
    }

    /**
     * setAclRuleDataMapper
     *
     * @param AclRuleDataMapperInterface $aclRuleDataMapper aclRuleDataMapper
     *
     * @return void
     */
    public function setAclRuleDataMapper(
        AclRuleDataMapperInterface $aclRuleDataMapper
    ) {
        $this->aclRuleDataMapper = $aclRuleDataMapper;
    }

    /**
     * getAclRuleDataMapper
     *
     * @return AclRuleDataMapperInterface
     */
    public function getAclRuleDataMapper()
    {
        return $this->aclRuleDataMapper;
    }

    /* ROLES ******************** */

    /**
     * getAclData
     *
     * @return array
     */
    public function getAclData()
    {
        $result = $this->fetchAllRoles();

        if (!$result->isSuccess()) {

            return $result;
        }

        $data = $result->getData();
    }

    /**
     * getRoleAclData
     *
     * @param string $roleId roleId
     *
     * @return void
     */
    public function getRoleAclData($roleId)
    {


    }

    /**
     * getDefaultRoleIdentities
     *
     * @return null
     */
    public function getDefaultRoleIdentities()
    {
        return $this->config->get('DefaultRoleIdentities', array());
    }

    /**
     * getDefaultAuthenticatedRoleIdentities
     *
     * @return null
     */
    public function getDefaultAuthenticatedRoleIdentities()
    {
        return $this->config->get('DefaultAuthenticatedRoleIdentities', array());
    }

    /**
     * getSuperAdminRole
     *
     * @return string|null
     */
    public function getSuperAdminRole()
    {
        return $this->config->get('SuperAdminRole', null);
    }

    /**
     * fetchAllRoles
     *
     * @return Result
     */
    public function fetchAllRoles()
    {
        return $this->aclRoleDataMapper->fetchAll();
    }

    /**
     * fetchRoleByRoleId
     *
     * @param string $roleId roleId
     *
     * @return mixed
     */
    public function fetchRoleByRoleId($roleId)
    {

        return $this->aclRoleDataMapper->fetchByRoleId($roleId);
    }

    /**
     * createRole
     *
     * @param AclRole $aclRole aclRole
     *
     * @return Result
     */
    public function createRole(AclRole $aclRole)
    {
        return $this->aclRoleDataMapper->create($aclRole);
    }

    /**
     * readRole
     *
     * @param AclRole $aclRole aclRole
     *
     * @return Result
     */
    public function readRole(AclRole $aclRole)
    {
        return $this->aclRoleDataMapper->read($aclRole);
    }

    /**
     * deleteRole
     *
     * @param AclRole $aclRole aclRole
     *
     * @return Result
     */
    public function deleteRole(AclRole $aclRole)
    {
        $roleId = $aclRole->getRoleId();

        $result = $this->aclRoleDataMapper->delete($aclRole);

        if (!$result->isSuccess()) {

            return $result;
        }

        $rulesResult = $this->fetchRulesByRole($roleId);

        if (!$rulesResult->isSuccess()) {

            $rulesResult->setMessage(
                'Could not remove related rules for role: ' . $roleId
            );
            return $rulesResult;
        }

        $aclRules = $rulesResult->getData();

        foreach ($aclRules as $aclRule) {

            $ruleResult = $this->deleteRule($aclRule);
            if (!$ruleResult->isSuccess()) {

                $result->setCode(Result::CODE_FAIL);
                $result->setMessage($ruleResult->getMessage());
            }
        }

        return $result;
    }

    /**
     * getRolesWithNamespace
     *
     * @param string $nsChar  nsChar
     * @param bool   $refresh refresh
     *
     * @return array
     */
    public function getRolesWithNamespace($nsChar = '.', $refresh = false)
    {
        $aclRoles = array();
        $roles = $this->getNamespacedRoles($nsChar, $refresh);

        foreach ($roles as $ns => $role) {

            $id = $role->getRoleId();
            $aclRoles[$id] = array();
            $aclRoles[$id]['role'] = $role;
            $aclRoles[$id]['roleNs'] = $ns;
        }

        return $aclRoles;
    }

    /**
     * getNamespacedRoles
     *
     * @param string $nsChar nsChar
     *
     * @return array
     */
    public function getNamespacedRoles($nsChar = '.')
    {
        $aclRoles = array();
        $result = $this->fetchAllRoles();

        if (!$result->isSuccess()) {

            return array();
        }

        $roles = $result->getData();

        foreach ($roles as $role) {

            $ns = $this->createRoleNamespaceId(
                $role,
                $roles,
                $nsChar
            );

            $aclRoles[$ns] = $role;
        }

        ksort($aclRoles);

        return $aclRoles;
    }

    /**
     * createRoleNamespaceId
     *
     * @param AclRole $aclRole  aclRole
     * @param array   $aclRoles aclRoles
     * @param string  $nsChar   nsChar
     *
     * @return string
     */
    public function createRoleNamespaceId(AclRole $aclRole, $aclRoles, $nsChar = '.')
    {
        $parentId = $aclRole->getParentRoleId();
        $ns = $aclRole->getRoleId();
        if (!empty($parentId)) {

            $parent = $aclRoles[$parentId];

            $ns = $this->createRoleNamespaceId($parent, $aclRoles, $nsChar) .
                $nsChar .
                $ns;
        }

        return $ns;
    }

    /* RULES ******************** */

    /**
     * fetchRulesAll
     *
     * @return \Result
     */
    public function fetchRulesAll()
    {
        return $this->aclRuleDataMapper->fetchAll();
    }

    /**
     * fetchRulesByResource
     *
     * @param string $resourceId $resourceId
     *
     * @return Result
     */
    public function fetchRulesByResource($resourceId)
    {
        return $this->aclRuleDataMapper->fetchByResource($resourceId);
    }

    /**
     * fetchRulesByRole
     *
     * @param string $roleId roleId
     *
     * @return Result
     */
    public function fetchRulesByRole($roleId)
    {
        return $this->aclRuleDataMapper->fetchByRole($roleId);
    }

    /**
     * createRule
     *
     * @param AclRule $aclRule aclRule
     *
     * @return Result
     */
    public function createRule(AclRule $aclRule)
    {
        $rule = $aclRule->getRule();
        $roleId = $aclRule->getRoleId();
        $resource = $aclRule->getResourceId();

        // check required
        if (empty($rule) || empty($roleId) || empty($resource)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                "New rule requires: rule, roleId and resourceId."
            );
        }

        // check if is super admin
        if ($roleId == $this->getSuperAdminRole()) {

            return new Result(
                null,
                Result::CODE_FAIL,
                "Rules cannot be assigned to super admin."
            );
        }

        // check if role exists
        $result = $this->fetchRoleByRoleId($roleId);

        if (!$result->isSuccess()) {

            return new Result(
                null,
                Result::CODE_FAIL,
                "Rules cannot be assigned to role that does not exist."
            );
        }

        // @todo validate resource/privilege exists

        return $this->aclRuleDataMapper->create($aclRule);
    }

    /**
     * createRule
     *
     * @param AclRule $aclRule aclRule
     *
     * @return Result
     */
    public function deleteRule(AclRule $aclRule)
    {
        $rule = $aclRule->getRule();
        $roleId = $aclRule->getRoleId();
        $resource = $aclRule->getResourceId();
        //$privilege = $aclRule->getPrivilege();

        // check required
        if (empty($rule) || empty($roleId) || empty($resource)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                "Rule requires: rule, roleId and resourceId."
            );
        }

        // check if exists and get valid id
        $result = $this->aclRuleDataMapper->read($aclRule);

        if (!$result->isSuccess()) {

            return $result;
        }

        return $this->aclRuleDataMapper->delete($result->getData());
    }

    /**
     * getRulesByRoles
     *
     * @param string $nsChar nsChar
     *
     * @return array
     */
    public function getRulesByRoles($nsChar = '.')
    {
        $aclRoles = array();
        $roles = $this->getNamespacedRoles($nsChar);

        foreach ($roles as $ns => $role) {

            $id = $role->getRoleId();
            $aclRoles[$ns] = array();
            $aclRoles[$ns]['role'] = $role;
            $aclRoles[$ns]['roleNs'] = $ns;
            $rulesResult = $this->fetchRulesByRole($id);
            if ($rulesResult->isSuccess()) {

                $aclRoles[$ns]['rules'] = $rulesResult->getData();
            } else {

                $aclRoles[$ns]['rules'] = array();
            }
        }

        return $aclRoles;
    }

} 