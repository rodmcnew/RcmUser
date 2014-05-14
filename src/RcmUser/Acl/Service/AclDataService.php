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
     * @var Config
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
     * @param Config $config
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
     * @param AclRoleDataMapperInterface $aclRoleDataMapper
     *
     * @return void
     */
    public function setAclRoleDataMapper(
        AclRoleDataMapperInterface $aclRoleDataMapper
    )
    {
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
     * @param AclRuleDataMapperInterface $aclRuleDataMapper
     *
     * @return void
     */
    public function setAclRuleDataMapper(
        AclRuleDataMapperInterface $aclRuleDataMapper
    )
    {
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

    public function getAclData()
    {
        $result = $this->fetchAllRoles();

        if(!$result->isSuccess()){

            return $result;
        }

        $data = $result->getData();
    }

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

    /* RULES ******************** */

    /**
     * fetchRulesAll
     *
     * @return \RcmUser\Acl\Db\Result
     */
    public function fetchRulesAll()
    {
        return $this->aclRuleDataMapper->fetchAll();
    }

    public function fetchRulesByResource($resource)
    {
        return $this->aclRuleDataMapper->fetchByResource($resource);
    }

    public function fetchRulesByRole($roleId)
    {
        return $this->aclRuleDataMapper->fetchByRole($roleId);
    }

    public function fetchRulesByRoles()
    {
        $result = $this->fetchAllRoles();

        if(!$result->isSuccess()){

            return $result;
        }

        $rules = array();

        foreach($result->getData() as $key => $role){

            $roleId = $role->getRoleId();
            $rules[$roleId] = array();
            $rules[$roleId]['role'] = $role;
            $rulesResult = $this->fetchRulesByRole($roleId);
            if($rulesResult->isSuccess()){

                $rules[$roleId]['rules'] = $rulesResult->getData();
            } else {

                $rules[$roleId]['rules'] = array();
            }
        }

        return new Result($rules);
    }

} 