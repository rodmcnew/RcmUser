<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Db;


use RcmUser\Acl\Db\AclRoleDataMapperInterface;
use RcmUser\Acl\Entity\AclRole;
use RcmUser\Db\DoctrineMapper;
use RcmUser\User\Entity\User;
use RcmUser\Result;

class DoctrineUserRoleDataMapper extends DoctrineMapper implements UserRolesDataMapperInterface
{
    protected $aclRoleDataMapper;

    /**
     * @param AclRoleDataMapperInterface $aclRoleDataMapper
     */
    public function setAclRoleDataMapper(AclRoleDataMapperInterface $aclRoleDataMapper)
    {
        $this->aclRoleDataMapper = $aclRoleDataMapper;
    }

    /**
     * @return AclRoleDataMapperInterface
     */
    public function getAclRoleDataMapper()
    {
        return $this->aclRoleDataMapper;
    }


    public function add(User $user, AclRole $role)
    {
        // @todo - write me
        throw new \Exception('Add User Roles not yet available.');
        $user = $this->getEntityManager()->find($this->getEntityClass(), $user->getId());
        if (empty($user)) {

            return new Result(null, Result::CODE_FAIL, 'User could not be found by id.');
        }

        // This is so we get a fresh user every time
        $this->getEntityManager()->refresh($user);

        return new Result($user);
    }

    public function remove(User $user, AclRole $role)
    {
        // @todo - write me
        throw new \Exception('Remove User Roles not yet available.');
        return new Result(null, Result::CODE_FAIL, 'Remove not yet available.');
    }

    public function create(User $user, $roles = array())
    {

        // @todo - write me
        //throw new \Exception('Create User Roles not yet available.');
        $userId = $user->getId();

        if (empty($userId)) {

            return new Result(null, Result::CODE_FAIL, 'User id required to get user roles.');
        }

        // check for existing roles
        // Save each role

        return new Result(null, Result::CODE_FAIL, 'Create not yet available.');
    }

    public function read(User $user)
    {

        $userId = $user->getId();

        if (empty($userId)) {

            return new Result(null, Result::CODE_FAIL, 'User id required to get user roles.');
        }

        //
        $userRoles = $this->getEntityManager()->getRepository($this->getEntityClass())->findBy(array('userId' => $userId));

        // This is so we get a fresh data every time
        // $this->getEntityManager()->refresh($userRoles);

        if (empty($userRoles)) {

            // @todo - set default roles and save?
            return new Result(null, Result::CODE_FAIL, 'User roles cannot be found.');
        }

        $aclRoleDataMapper = $this->getAclRoleDataMapper();

        $userAclRoles = array();

        foreach ($userRoles as $userRole) {

            // @todo data checks here

            $aclRoleResult = $aclRoleDataMapper->fetchById($userRole->getRoleId());

            if(!$aclRoleResult->isSuccess()){

                //@todo - error
                continue;
            }

            $aclRole = $aclRoleResult->getData();

            if (empty($aclRole)) {

                // @todo handle this by either removing role or throwing error
            } else {

                $userAclRoles[] = $aclRole->getRoleIdentity();
            }
        }


        return new Result($userAclRoles);
    }

    public function update(User $user, $roles = array())
    {
        // @todo - write me
        //throw new \Exception('Update User Roles not yet available.');
        return new Result(null, Result::CODE_FAIL, 'Update not yet available.');
    }

    public function delete(User $user)
    {
        // @todo - write me
        //throw new \Exception('Delete User Roles not yet available.');
        return new Result(null, Result::CODE_FAIL, 'Delete not yet available.');
    }


} 