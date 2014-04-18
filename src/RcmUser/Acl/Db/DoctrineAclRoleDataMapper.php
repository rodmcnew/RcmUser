<?php
/**
 * DoctrineAclRoleDataMapper.php
 *
 * DoctrineAclRoleDataMapper
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
use RcmUser\Acl\Entity\BjyAclRole;
use RcmUser\Acl\Entity\DoctrineAclRole;
use RcmUser\Db\DoctrineMapper;
use RcmUser\Result;

/**
 * DoctrineAclRoleDataMapper
 *
 * DoctrineAclRoleDataMapper
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
class DoctrineAclRoleDataMapper
    extends DoctrineMapper
    implements AclRoleDataMapperInterface
{
    /**
     * fetchAll
     *
     * @return Result|Result
     */
    public function fetchAll()
    {
        //$roles = $this->getEntityManager()->getRepository($this->getEntityClass())->findAll();

        $query = $this->getEntityManager()->createQuery(
            '
                        SELECT role FROM ' . $this->getEntityClass() . ' role
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
     * fetchById
     *
     * @param int $id id
     *
     * @return Result|Result
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
     * fetchByParentId
     *
     * @param mixed $parentId the parent id
     *
     * @return array
     */
    public function fetchByParentId($parentId)
    {
        $roles = $this->getEntityManager()->getRepository($this->getEntityClass())
            ->findBy(array('parentId' => $parentId));

        if (empty($roles)) {

            return new Result(null, Result::CODE_FAIL, 'Roles could not be found by parentId.');
        }

        return new Result($roles);
    }

    /**
     * fetchByRoleIdentity
     *
     * @param string $roleIdentity the role identity string
     *
     * @return Role
     */
    public function fetchByRoleIdentity($roleIdentity)
    {
        $roles = $this->getEntityManager()->getRepository($this->getEntityClass())
            ->findBy(array('roleIdentity' => $roleIdentity));

        if (empty($roles)) {

            return new Result(null, Result::CODE_FAIL, 'Roles could not be found by roleIdentity.');
        }

        return new Result($roles);
    }

    /**
     * create
     *
     * @param AclRole $aclRole acl role
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
     * read
     *
     * @param AclRole $aclRole the acl role
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
     * update
     *
     * @param AclRole $aclRole acl role
     *
     * @return mixed
     */
    public function update(AclRole $aclRole)
    {
        return new Result(null, Result::CODE_FAIL, 'Acl Role update NOT YET AVAILABLE.');
    }

    /**
     * delete
     *
     * @param AclRole $aclRole acl role
     *
     * @return mixed
     */
    public function delete(AclRole $aclRole)
    {
        return new Result(null, Result::CODE_FAIL, 'Acl Role delete NOT YET AVAILABLE.');
    }

    /**
     * getValidInstance
     *
     * @param AclRole $aclRole acl role
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
     * prepareRoles
     *
     * @param array $roles indexed by id
     *
     * @return array
     */
    public function prepareRoles($roles)
    {


        foreach ($roles as $key => $role) {

            $parentId = $role->getParentId();

            if (isset($roles[$parentId])) {
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
     * createNamespaceId
     *
     * @param AclRole $role     acl role
     * @param array   $aclRoles array of roles
     *
     * @return string
     */
    public function createNamespaceId(AclRole $role, $aclRoles)
    {

        $parentId = $role->getParentId();
        $ns = $role->getRoleIdentity();
        if (!empty($parentId)) {

            $parent = $aclRoles[$parentId];

            $ns = $this->createNamespaceId($parent, $aclRoles, $ns) . '.' . $ns;
        }

        return $ns;
    }
} 