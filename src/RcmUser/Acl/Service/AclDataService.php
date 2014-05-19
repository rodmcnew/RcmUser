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
     * @return \RcmUser\Acl\Db\Result
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
     * @return \RcmUser\Acl\Db\Result
     */
    public function fetchAllRoles()
    {
        return $this->aclRoleDataMapper->fetchAll();
    }

    /**
     * getResourcesWithNamespaced
     *
     * @param string $nsChar  nsChar
     * @param bool   $refresh refresh
     *
     * @return array
     */
    public function getRolesWithNamespaced($nsChar = '.', $refresh = false)
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

            $ns = $this->createRoleNamespaceId($parent, $aclRoles, $nsChar) . $nsChar
                . $ns;
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
     * @param string $resource resource
     *
     * @return Result
     */
    public function fetchRulesByResource($resource)
    {
        return $this->aclRuleDataMapper->fetchByResource($resource);
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