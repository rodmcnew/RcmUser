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
     * @param array $options options
     *
     * @return Result
     */
    public function fetchAll($options = array())
    {
        $users = $this->getEntityManager()
            ->getRepository($this->getEntityClass())
            ->findAll();

        return new Result($users);
    }

    /**
     * add
     *
     * @param User   $user      user
     * @param string $aclRoleId aclRoleId
     *
     * @return Result
     */
    public function add(User $user, $aclRoleId)
    {
        if (!$this->canAdd($user, $aclRoleId)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'Role not available to add or user not valid.'
            );
        }

        $result = $this->read($user);

        if (!$result->isSuccess()) {

            $result->setMessage("Could not add role: {$aclRoleId}");

            return $result;
        }


        $currentRoles = $result->getData();

        if (in_array($aclRoleId, $currentRoles)) {

            return new Result(
                $aclRoleId,
                Result::CODE_FAIL,
                "Role: {$aclRoleId} already exists."
            );
        }

        $userId = $user->getId();

        $userRole = new DoctrineUserRole();
        $userRole->setUserId($userId);
        $userRole->setRoleId($aclRoleId);

        $this->getEntityManager()->persist($userRole);
        $this->getEntityManager()->flush();

        return new Result(
            $aclRoleId,
            Result::CODE_SUCCESS,
            'Role added.'
        );
    }

    /**
     * remove
     *
     * @param User   $user      user
     * @param string $aclRoleId aclRoleId
     *
     * @return Result
     */
    public function remove(User $user, $aclRoleId)
    {
        if(!$this->canRemove($user, $aclRoleId)){
            return new Result(
                null,
                Result::CODE_FAIL,
                'Missing user id to remove role.'
            );
        }

        $userId = $user->getId();

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

        return new Result(
            $aclRoleId,
            Result::CODE_SUCCESS,
            'Role removed.'
        );
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
        $currentRoles = $currentRolesResult->getData();

        if (!empty($currentRoles)) {

            return new Result(
                $currentRolesResult->getData(),
                Result::CODE_FAIL,
                'Roles already exist for user: ' . $user->getId()
            );
        }

        $returnResult = new Result(
            array(),
            Result::CODE_SUCCESS
        );

        foreach ($userRoles as $key => $roleId) {

            $aclRoleResult = $this->getAclRoleDataMapper()->fetchByRoleId($roleId);

            $aclRole = $aclRoleResult->getData();

            if (!$aclRoleResult->isSuccess() || empty($aclRole)) {

                $returnResult->setCode(Result::CODE_FAIL);
                $returnResult->setMessage(
                    "Failed to add role {$roleId} with error: " .
                    $aclRoleResult->getMessage()
                );

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

        $returnResult->setData($userRoles);

        return $returnResult;
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
        if (empty($userAclRoles)) {

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

        $availableRoles = $this->getAvailableRoles();

        if (empty($availableRoles)) {

            throw new RcmUserException('No roles are available to assign.');
        }

        $failed = array();
        $returnResult = new Result(
            $failed,
            Result::CODE_SUCCESS
        );

        $addRoles = array_diff($roles, $curRoles);
        $invalidRoles = $curRoles;
        $addedRoles = array();

        // build new roles
        foreach ($availableRoles as $aclRole) {

            $roleId = $aclRole->getRoleId();

            if (in_array($roleId, $addRoles)) {

                $addResult = $this->add($user, $roleId);

                if (!$addResult->isSuccess()) {

                    $failed[] = $roleId;
                    $returnResult->setCode(Result::CODE_FAIL);
                    $returnResult->setMessage(
                        "Failed to add role {$roleId} with error: " .
                        $addResult->getMessage()
                    );
                    $returnResult->setData($failed);
                } else {

                    $addedRoles[] = $roleId;
                }
            }

            // trim out current roles as we find them to leave only roles that
            // do not exist
            $index = array_search($roleId, $invalidRoles);
            if ($index !== false) {

                unset($invalidRoles[$index]);
            }
        }

        $removeRoles = array_diff($curRoles, $roles);
        $removeRoles = array_merge($removeRoles, $invalidRoles);
        $removedRoles = array();

        foreach ($removeRoles as $roleId) {

            $removeResult = $this->remove($user, $roleId);

            if (!$removeResult->isSuccess()) {

                $failed[] = $roleId;
                $returnResult->setCode(Result::CODE_FAIL);
                $returnResult->setMessage(
                    "Failed to remove role {$roleId} with error: " .
                    $removeResult->getMessage()
                );
                $returnResult->setData($failed);
            } else {

                $removedRoles[] = $roleId;
            }
        }

        $ignored = array_diff($addRoles, $addedRoles);

        $result = $this->read($user);

        if ($result->isSuccess()) {

            $curRoles = $result->getData();
        } else {

            $curRoles = array();
        }

        $returnResult->setData(
            $curRoles
        );

        $resultInfo = array(
            'added' => $addedRoles,
            'removed' => $removedRoles,
            'ignored' => $ignored,
        );

        $returnResult->setMessage(json_encode($resultInfo));

        return $returnResult;
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
        $failed = array();

        $result = new Result(
            $failed,
            Result::CODE_SUCCESS
        );

        foreach ($roles as $key => $roleId) {

            $removeResult = $this->remove($user, $roleId);

            if (!$removeResult->isSuccess()) {

                $failed[] = $roleId;
                $result->setCode(Result::CODE_FAIL);
                $result->setMessage(
                    "Failed to remove role {$roleId} with error: " .
                    $removeResult->getMessage()
                );
                $result->setData($failed);
            }
        }

        return $result;
    }
} 