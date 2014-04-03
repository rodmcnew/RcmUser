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
use RcmUser\Db\DoctrineMapper;
use RcmUser\Result;

/**
 * Interface AclRoleDataMapperInterface
 *
 * @package RcmUser\User\Db
 */
class DoctrineAclRoleDataMapper extends DoctrineMapper implements AclRoleDataMapperInterface
{
    /**
     * @return array
     */
    public function fetchAll()
    {
        $roles = $this->getEntityManager()->getRepository($this->getEntityClass())->findAll();

        if (empty($roles)) {

            return new Result(null, Result::CODE_FAIL, 'Roles could not be found.');
        }

        return new Result($roles);
    }

    /**
     * @param int $id
     *
     * @return Role
     */
    public function fetchById($id)
    {
        $role = $this->getEntityManager()->find($this->getEntityClass(), $id);

        if (empty($role)) {

            return new Result(null, Result::CODE_FAIL, 'Role could not be found by id.');
        }

        // This is so we get a fresh user every time
        $this->getEntityManager()->refresh($role);

        return new Result($role);
    }

    /**
     * @param $parentId
     *
     * @return array
     */
    public function fetchByParentId($parentId)
    {
        $roles = $this->getEntityManager()->getRepository($this->getEntityClass())->findBy(array('parentId' => $parentId));

        if (empty($roles)) {

            return new Result(null, Result::CODE_FAIL, 'Roles could not be found by parentId.');
        }

        return new Result($roles);
    }

    /**
     * @param $roleIdentity
     *
     * @return Role
     */
    public function fetchByRoleIdentity($roleIdentity)
    {
        $roles = $this->getEntityManager()->getRepository($this->getEntityClass())->findBy(array('roleIdentity' => $roleIdentity));

        if (empty($roles)) {

            return new Result(null, Result::CODE_FAIL, 'Roles could not be found by roleIdentity.');
        }

        return new Result($roles);
    }

    /**
     * @param AclRole $aclRole
     *
     * @return mixed|void
     */
    public function create(AclRole $aclRole)
    {
        $result = $this->getValidInstance($aclRole);

        $aclRole = $result->getData();

        // @todo if error, fail with null
        $this->getEntityManager()->persist($aclRole);
        $this->getEntityManager()->flush();

        return new Result($aclRole);
    }

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function read(AclRole $aclRole)
    {
        $result = $this->getValidInstance($aclRole);

        $aclRole = $result->getUser();
        $id = $aclRole->getId();

        if (!empty($id)) {

            $result = $this->fetchById($id);

            if($result->isSuccess()){

                return $result;
            }
        }

        $roleIdentity = $aclRole->getRoleIdentity();

        if (!empty($roleIdentity)) {

            $result = $this->fetchByRoleIdentity($roleIdentity);

            return $result;
        }

        return new Result(null, Result::CODE_FAIL, 'User could not be read.');
    }

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function update(AclRole $aclRole)
    {

    }

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function delete(AclRole $aclRole)
    {

    }

    /**
     * @param AclRole $aclRole
     *
     * @return Result
     */
    public function getValidInstance(AclRole $aclRole)
    {

        if (!($aclRole instanceof AclRole)) {

            $doctrineAclRole = new AclRole();
            $doctrineAclRole->populate($aclRole);

            $aclRole = $doctrineAclRole;
        }

        return new Result($aclRole);
    }
} 