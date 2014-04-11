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
use RcmUser\Acl\Entity\BjyAclRole;
use RcmUser\Acl\Entity\DoctrineAclRole;
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
        //$roles = $this->getEntityManager()->getRepository($this->getEntityClass())->findAll();

        $query = $this->getEntityManager()->createQuery('
            SELECT role FROM '.$this->getEntityClass().' role
            INDEX BY role.id'
        );

        $roles = $query->getResult();

        if (empty($roles)) {

            return new Result(null, Result::CODE_FAIL, 'Roles could not be found.');
        }

        $roles = $this->prepareRoles($roles);

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

        $aclRole = $result->getData();
        $id = $aclRole->getId();

        if (!empty($id)) {

            $result = $this->fetchById($id);

            if ($result->isSuccess()) {

                return $result;
            }
        }

        $roleIdentity = $aclRole->getRoleIdentity();

        if (!empty($roleIdentity)) {

            $result = $this->fetchByRoleIdentity($roleIdentity);

            return $result;
        }

        return new Result(null, Result::CODE_FAIL, 'Acl Role could not be read.');
    }

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function update(AclRole $aclRole)
    {
        return new Result(null, Result::CODE_FAIL, 'Acl Role update NOT YET AVAILABLE.');
    }

    /**
     * @param AclRole $aclRole
     *
     * @return mixed
     */
    public function delete(AclRole $aclRole)
    {
        return new Result(null, Result::CODE_FAIL, 'Acl Role delete NOT YET AVAILABLE.');
    }

    /**
     * @param AclRole $aclRole
     *
     * @return Result
     */
    public function getValidInstance(AclRole $aclRole)
    {

        if (!($aclRole instanceof AclRole)) {

            $doctrineAclRole = new DoctrineAclRole();
            $doctrineAclRole->populate($aclRole);

            $aclRole = $doctrineAclRole;
        }

        return new Result($aclRole);
    }


    /**
     * @param array $roles indexed by id
     *
     * @return array
     */
    public function prepareRoles($roles){


        foreach($roles as $key => $role){

            $parentId = $role->getParentId();

            if(isset($roles[$parentId])){
                /*@todo We clone to limit nesting, is this ok?
                $parent = new AclRole();
                $parent->populate($roles[$parentId]);

                $roles[$key]->setParentRole($parent);
                */

                // @todo this should take objects, not strings, BJY has issues with objects
                $roles[$key]->setParentRole($roles[$parentId]->getRoleIdentity());
            }
        }

        return $roles;
    }
    /**
     * @param AclRole $role
     * @param         $aclRoles
     *
     * @return string
     */
    public function createNamespaceId(AclRole $role, $aclRoles){

        $parentId = $role->getParentId();
        $ns = $role->getRoleIdentity();
        if(!empty($parentId)){

            $parent = $aclRoles[$parentId];

            $ns = $this->createNamespaceId($parent, $aclRoles, $ns) . '.' . $ns;
        }

        return $ns;
    }
} 