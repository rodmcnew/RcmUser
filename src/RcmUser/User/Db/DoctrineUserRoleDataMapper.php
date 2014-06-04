<?php
/**
 * DoctrineUserRoleDataMapper.php
 *
 * DoctrineUserRoleDataMapper
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


use Doctrine\ORM\EntityManager;
use RcmUser\Acl\Entity\AclRole;
use RcmUser\Db\DoctrineMapperInterface;
use RcmUser\Exception\RcmUserException;
use RcmUser\Result;
use RcmUser\User\Entity\DoctrineUserRole;
use RcmUser\User\Entity\User;

/**
 * Class DoctrineUserRoleDataMapper
 *
 * DoctrineUserRoleDataMapper
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
class DoctrineUserRoleDataMapper
    extends UserRolesDataMapper
    implements DoctrineMapperInterface
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
     * @return mixed
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function fetchAll()
    {
        $users = $this->getEntityManager()
            ->getRepository($this->getEntityClass())
            ->findAll();

        return new Result($users);
    }

    /**
     * add
     *
     * @param User    $user      user
     * @param AclRole $aclRoleId aclRoleId
     *
     * @return Result
     */
    public function add(User $user, $aclRoleId)
    {
        $userId = $user->getId();

        if (empty($userId)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User id required to add user role.'
            );
        }

        $userRole = new DoctrineUserRole();
        $userRole->setUserId($userId);
        $userRole->setRoleId($aclRoleId);

        $this->getEntityManager()->persist($userRole);
        $this->getEntityManager()->flush();

        return new Result($userRole);
    }

    /**
     * remove
     *
     * @param User    $user      user
     * @param AclRole $aclRoleId aclRoleId
     *
     * @return Result
     */
    public function remove(User $user, $aclRoleId)
    {
        $userId = $user->getId();

        if (empty($userId)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User id required to add user role.'
            );
        }

        $userRoles = $this->getEntityManager()->getRepository(
            $this->getEntityClass()
        )->findBy(
            array(
                'userId' => $userId,
                'roleId' => $aclRoleId,
            )
        );

        foreach ($userRoles as $userRole) {

            $this->getEntityManager()->remove($userRole);
        }

        $this->getEntityManager()->flush();

        return new Result();
    }

    /**
     * create
     *
     * @param User  $user      user
     * @param array $userRoles userRoles
     *
     * @return Result|Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function create(User $user, $userRoles = array())
    {
        $userId = $user->getId();

        if (empty($userId)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User id required to get user roles.'
            );
        }

        $currentRolesResult = $this->read($user);

        if ($currentRolesResult->isSuccess()) {

            return new Result(
                $currentRolesResult->getData(),
                Result::CODE_FAIL,
                'Roles already exist for user: ' . $user->getId()
            );
        }

        foreach ($userRoles as $key => $roleId) {

            $aclRoleResult = $this->getAclRoleDataMapper()->fetchByRoleId($roleId);

            $aclRole = $aclRoleResult->getData();

            if (!$aclRoleResult->isSuccess() || empty($aclRole)) {

                // error/ignore undefined roles
                unset($userRoles[$key]);
                continue;
            }

            $userRole = new DoctrineUserRole();
            $userRole->setUserId($userId);
            $userRole->setRoleId($aclRole->getRoleId());

            $this->getEntityManager()->persist($userRole);
        }

        $this->getEntityManager()->flush();

        // @todo check for failure

        return new Result($userRoles);
    }

    /**
     * read
     *
     * @param User $user user
     *
     * @return Result
     */
    public function read(User $user)
    {
        $userId = $user->getId();

        if (empty($userId)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User id required to get user roles.'
            );
        }

        $query = $this->getEntityManager()->createQuery(
            'SELECT userRole.roleId FROM ' . $this->getEntityClass() . ' userRole ' .
            'INDEX BY userRole.roleId ' .
            'WHERE userRole.userId = ?1'
        );

        $query->setParameter(1, $userId);

        $userRoles = $query->getResult();

        $userAclRoles = array();

        foreach ($userRoles as $userRole) {

            $userAclRoles[] = $userRole['roleId'];
        }

        $message = '';
        if(empty($userAclRoles)){

            $message = 'No roles found';
        }

        return new Result($userAclRoles, Result::CODE_SUCCESS, $message);
    }

    /**
     * update
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result|Result
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function update(User $user, $roles = array())
    {
        $result = $this->read($user);

        if ($result->isSuccess()) {

            $curRoles = $result->getData();
        } else {

            $curRoles = array();
        }

        $result = $this->getAclRoleDataMapper()->fetchAll();

        if ($result->isSuccess()) {

            $availableRoles = $result->getData();
        } else {

            throw new RcmUserException('No roles are available to assign.');
        }

        $userAclRoles = array();

        foreach ($availableRoles as $key => $aclRole) {

            $roleId = $aclRole->getRoleId();

            if (in_array($roleId, $curRoles) && !in_array($roleId, $roles)) {
                $this->remove($user, $roleId);
                unset($curRoles[$key]);
            }
            if (in_array($roleId, $roles) && !in_array($roleId, $curRoles)) {

                $this->add($user, $roleId);
                $userAclRoles[$roleId] = $roleId;
                unset($roles[$key]);
            }
        }

        // make sure roles are valid
        // $roles should be empty, anything left was unavailable
        if (!empty($roles)) {
            // remove the rest
            foreach ($roles as $key => $roleId) {
                $this->remove($user, $roleId);
            }
        }

        if (!empty($curRoles)) {
            // remove the rest
            foreach ($roles as $key => $roleId) {
                $this->remove($user, $roleId);
            }
        }

        return new Result($userAclRoles);
    }

    /**
     * delete
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function delete(User $user, $roles = array())
    {
        foreach ($roles as $key => $roleId) {
            $this->remove($user, $roleId);
        }

        return new Result();
    }
} 