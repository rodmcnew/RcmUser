<?php
/**
 * UserRolesDataMapper.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Db;

use RcmUser\Acl\Db\AclRoleDataMapperInterface;
use RcmUser\Acl\Entity\AclRole;
use RcmUser\Exception\RcmUserException;
use RcmUser\User\Entity\User;


/**
 * Class UserRolesDataMapper
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserRolesDataMapper implements UserRolesDataMapperInterface
{
    /**
     * @var AclRoleDataMapperInterface $aclRoleDataMapper
     */
    protected $aclRoleDataMapper;

    /**
     * @var array $availableRoles
     */
    protected $availableRoles = array();

    /**
     * __construct
     *
     * @param AclRoleDataMapperInterface $aclRoleDataMapper aclRoleDataMapper
     */
    public function __construct(AclRoleDataMapperInterface $aclRoleDataMapper)
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
     * getAvailableRoles
     *
     * @return array
     */
    public function getAvailableRoles()
    {
        if (!empty($this->availableRoles)) {

            return $this->availableRoles;
        }

        $result = $this->getAclRoleDataMapper()->fetchAll();

        if ($result->isSuccess()) {

            $this->availableRoles = $result->getData();
        }

        return $this->availableRoles;
    }

    /**
     * fetchAll
     *
     * @param array $options options
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function fetchAll($options = array())
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * add
     *
     * @param User    $user      user
     * @param string $aclRoleId aclRoleId
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function add(User $user, $aclRoleId)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * remove
     *
     * @param User    $user      user
     * @param string $aclRoleId aclRoleId
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function remove(User $user, $aclRoleId)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * create
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function create(User $user, $roles = array())
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * read
     *
     * @param User $user user
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function read(User $user)
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * update
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function update(User $user, $roles = array())
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }

    /**
     * delete
     *
     * @param User $user user
     * @param array $roles roles
     *
     * @return Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function delete(User $user, $roles = array())
    {
        throw new RcmUserException("Method " . __METHOD__ . " not implemented.");
    }


    /**
     * canAdd
     *
     * @param User   $user user
     * @param string $role role id
     *
     * @return bool
     */
    public function canAdd(User $user, $role)
    {
        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        $availableRoles = $this->getAvailableRoles();

        if(!in_array($role, $availableRoles)) {

            return false;
        }

        return true;
    }

    /**
     * canRemove
     *
     * @param User   $user user
     * @param string $role role id
     *
     * @return bool
     */
    public function canRemove(User $user, $role)
    {
        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        return true;
    }
} 