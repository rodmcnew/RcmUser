<?php
/**
 * AclRoleDataMapper.php
 *
 * AclRoleDataMapper
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
use RcmUser\Config\Config;
use RcmUser\Exception\RcmUserException;

/**
 * class AclRoleDataMapper
 *
 * AclRoleDataMapper
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
class AclRoleDataMapper implements AclRoleDataMapperInterface
{

    protected $config = null;


    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * fetchSuperAdminRoleId
     *
     * @return string|null
     * @throws RcmUserException
     */
    public function fetchSuperAdminRoleId()
    {
        if(!empty($this->config)){
            return $this->config->get('SuperAdminRoleId', null);
        }

        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * fetchGuestRoleId
     *
     * @return string|null
     * @throws RcmUserException
     */
    public function fetchGuestRoleId()
    {
        if(!empty($this->config)){
            return $this->config->get('GuestRoleId', null);
        }

        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * fetchDefaultGuestRoleIds
     *
     * @return array
     * @throws RcmUserException
     */
    public function fetchDefaultGuestRoleIds()
    {
        if(!empty($this->config)){
            return $this->config->get('DefaultGuestRoleIds', array());
        }

        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * fetchDefaultUserRoleIds
     *
     * @return array
     * @throws RcmUserException
     */
    public function fetchDefaultUserRoleIds()
    {
        if(!empty($this->config)){
            return $this->config->get('DefaultUserRoleIds', array());
        }

        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * fetchAll
     *
     * @return Result
     * @throws RcmUserException
     */
    public function fetchAll()
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * fetchByRoleId
     *
     * @param string $roleId roleId
     *
     * @return mixed
     * @throws RcmUserException
     */
    public function fetchByRoleId($roleId)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * fetchByParentRoleId
     *
     * @param int $parentRoleId parent id
     *
     * @return Result
     * @throws RcmUserException
     */
    public function fetchByParentRoleId($parentRoleId)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * create
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     * @throws RcmUserException
     */
    public function create(AclRole $aclRole)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * read
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     * @throws RcmUserException
     */
    public function read(AclRole $aclRole)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * update
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     * @throws RcmUserException
     */
    public function update(AclRole $aclRole)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * delete
     *
     * @param AclRole $aclRole acl role
     *
     * @return Result
     * @throws RcmUserException
     */
    public function delete(AclRole $aclRole)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }
} 