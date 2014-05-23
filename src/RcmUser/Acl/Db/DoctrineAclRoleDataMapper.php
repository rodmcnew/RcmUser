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


use Doctrine\ORM\EntityManager;
use RcmUser\Acl\Entity\AclRole;
use RcmUser\Acl\Entity\DoctrineAclRole;
use RcmUser\Db\DoctrineMapperInterface;
use RcmUser\Exception\RcmUserException;
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
    extends AclRoleDataMapper
    implements AclRoleDataMapperInterface, DoctrineMapperInterface
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var
     */
    protected $entityClass;

    /**
     * setEntityManager
     *
     * @param EntityManager $entityManager entityManager
     *
     * @return void
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * getEntityManager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {

        return $this->entityManager;
    }

    /**
     * setEntityClass
     *
     * @param string $entityClass entityClass namespace
     *
     * @return void
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = (string)$entityClass;
    }

    /**
     * getEntityClass
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * fetchAll
     *
     * @return Result|Result
     */
    public function fetchAll()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT role FROM ' . $this->getEntityClass() . ' role ' .
            'INDEX BY role.roleId'
        );

        $roles = $query->getResult();

        return new Result($roles);
    }

    /**
     * fetchByRoleId
     *
     * @param string $roleId the role identity string
     *
     * @return Role
     */
    public function fetchByRoleId($roleId)
    {
        $roles = $this->getEntityManager()->getRepository($this->getEntityClass())
            ->findOneBy(array('roleId' => $roleId));

        return new Result($roles);
    }

    /**
     * fetchByParentRoleId
     *
     * @param mixed $parentRoleId the parent id
     *
     * @return array
     */
    public function fetchByParentRoleId($parentRoleId)
    {
        $roles = $this->getEntityManager()->getRepository($this->getEntityClass())
            ->findBy(array('parentRoleId' => $parentRoleId));

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
        
        $result = $this->read($aclRole);

        $existingAclRole = $result->getData();

        if ($result->isSuccess() && !empty($existingAclRole)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'Acl Role already exists: ' . var_export($aclRole, true)
            );
        }

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
        $roleId = $aclRole->getRoleId();

        if (!empty($roleId)) {

            $result = $this->fetchByRoleId($roleId);

            return $result;
        }

        return new Result(
            null,
            Result::CODE_FAIL,
            'Acl Role could not be read.'
        );
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
        $result = $this->read($aclRole);

        if (!$result->isSuccess()) {

            return $result;
        }

        $aclRole = $result->getData();

        if (empty($aclRole)) {

            return new Result(
                null,
                Result::CODE_SUCCESS,
                'Role not found to update: ' . $aclRole->getRoleId()
            );
        }

        $this->getEntityManager()->merge($aclRole);
        $this->getEntityManager()->flush();

        // @todo validate action
        return new Result(
            null,
            Result::CODE_SUCCESS,
            'Successfully updated ' . $aclRole->getRoleId()
        );
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
        $aclRoleId = $aclRole->getRoleId();
        $result = $this->read($aclRole);

        if (!$result->isSuccess()) {

            return $result;
        }

        $aclRole = $result->getData();

        if (empty($aclRole)) {

            return new Result(
                null,
                Result::CODE_SUCCESS,
                'Role not found to update: ' . $aclRoleId
            );
        }

        $aclRoleId = $aclRole->getRoleId();
        $parentRoleId = $aclRole->getParentRoleId();

        $result = $this->fetchByParentRoleId($aclRoleId);

        if (!$result->isSuccess()) {

            $result->setMessage(
                'Failed to find child roles for  ' .
                $aclRole->getRoleId() . '.'
            );

            return $result;
        }

        $childRoles = $result->getData();

        foreach ($childRoles as $childRole) {

            $childRole->setParentRoleId($parentRoleId);
            $childResult = $this->update($childRole);

            if (!$childResult->isSuccess()) {

                $result->setCode(Result::CODE_FAIL);
                $result->setMessage($childResult->getMessage());
            }
        }

        if (!$result->isSuccess()) {

            $result->setMessage(
                'Failed to update child roles for delete of ' .
                $aclRole->getRoleId() . '.'
            );

            return $result;
        }

        $this->getEntityManager()->remove($aclRole);
        $this->getEntityManager()->flush();

        // @todo validate action results

        return new Result(
            null,
            Result::CODE_SUCCESS,
            'Successfully deleted ' . $aclRoleId
        );
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
        if (!($aclRole instanceof DoctrineAclRole)) {

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

            $parentRoleId = $role->getParentRoleId();

            if (isset($roles[$parentRoleId])) {

                $roles[$key]->setParentRole($roles[$parentRoleId]);
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
        $parentRoleId = $role->getParentRoleId();
        $ns = $role->getRoleId();
        if (!empty($parentRoleId)) {

            $parent = $aclRoles[$parentRoleId];

            $ns = $this->createNamespaceId($parent, $aclRoles, $ns) . '.' . $ns;
        }

        return $ns;
    }
} 