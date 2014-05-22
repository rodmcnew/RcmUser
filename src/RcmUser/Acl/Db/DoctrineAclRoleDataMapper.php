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
        //$roles = $this->getEntityManager()->getRepository(
        //    $this->getEntityClass()
        //)->findAll();

        $query = $this->getEntityManager()->createQuery(
            'SELECT role FROM ' . $this->getEntityClass() . ' role ' .
            'INDEX BY role.roleId'
        );

        $roles = $query->getResult();

        if (empty($roles)) {

            return new Result(null, Result::CODE_FAIL, 'Roles could not be found.');
        }

        //$roles = $this->prepareRoles($roles);

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

        if (empty($roles)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'Roles could not be found by roleId.'
            );
        }

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

        if (empty($roles)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'Roles could not be found by parentRoleId.'
            );
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

        $roleId = $aclRole->getRoleId();

        if (!empty($roleId)) {

            $result = $this->fetchByRoleId($roleId);

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
        $result = $this->getValidInstance($aclRole);

        $aclRole = $result->getData();

        $this->getEntityManager()->merge($aclRole);
        $this->getEntityManager()->flush();

        // @todo validate action
        return new Result(
            null,
            Result::CODE_SUCCESS
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
        $result = $this->getValidInstance($aclRole);

        $aclRole = $result->getData();

        $this->getEntityManager()->remove($aclRole);
        $this->getEntityManager()->flush();

        // @todo validate action
        return new Result(
            null,
            Result::CODE_SUCCESS
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