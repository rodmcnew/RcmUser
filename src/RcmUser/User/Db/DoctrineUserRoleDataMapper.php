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
use RcmUser\Acl\Db\AclRoleDataMapperInterface;
use RcmUser\Acl\Entity\AclRole;
use RcmUser\Db\DoctrineMapper;
use RcmUser\Db\DoctrineMapperInterface;
use RcmUser\Exception\RcmUserException;
use RcmUser\User\Entity\DoctrineUserRole;
use RcmUser\User\Entity\User;
use RcmUser\Result;

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
     * @var AclRoleDataMapperInterface $aclRoleDataMapper
     */
    protected $aclRoleDataMapper;

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
     * setAclRoleDataMapper
     *
     * @param AclRoleDataMapperInterface $aclRoleDataMapper aclRoleDataMapper
     *
     * @return void
     */
    public function setAclRoleDataMapper(
        AclRoleDataMapperInterface $aclRoleDataMapper
    ) {
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

        if($currentRolesResult->isSuccess()){

            throw new RcmUserException('Roles already exist for user: ' . $user->getId());
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

        if (empty($userRoles)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'User roles cannot be found.'
            );
        }

        $userAclRoles = array();

        foreach ($userRoles as $userRole) {

            $userAclRoles[] = $userRole['roleId'];
        }

        return new Result($userAclRoles);
    }

    /**
     * update
     *
     * @param User  $user  user
     * @param array $roles roles
     *
     * @return Result
     */
    public function update(User $user, $roles = array())
    {

        var_dump("\n***Update User Roles not yet available. Update not done***\n");
        return new Result(null, Result::CODE_FAIL, 'Update not yet available.');

        $result = $this->read($user);

        if($result->isSuccess()){

            $curRoles = $result->getData();
        } else {

            $curRoles = array();
        }

        $availableRoles = $this->getAclRoleDataMapper()->fetchAll();

        if($result->isSuccess()){

            $availableRoles = $result->getData();
        } else {

            throw new RcmUserException('No roles are available to assign.');
            //$availableRoles = array();
        }

        $userAclRoles = array();

        foreach($availableRoles as $key => $role){

            if(in_array($curRoles, $key) && !in_array($roles, $key)){
                // @todo delete role
                unset($curRoles[$key]);
            }
            if(in_array($roles, $key) && !in_array($curRoles, $key)){
                // @todo add role
                $userAclRoles[$key] = $roles[$key];
                unset($roles[$key]);
            }
        }

        // make sure roles are valid
        // $roles should be empty, anything left was unavailable
        if(!empty($roles)){
            // remove the rest
            foreach($roles as $key => $role){
                // @todo delete role
            }
        }

        if(!empty($curRoles)){
            // remove the rest
            foreach($roles as $key => $role){
                // @todo delete role
            }
        }

        return new Result($userAclRoles);
    }

    /**
     * delete
     *
     * @param User $user user
     *
     * @return Result
     */
    public function delete(User $user)
    {
        // @todo - write me
        //throw new \Exception('Delete User Roles not yet available.');
        var_dump("\n***Delete User Roles not yet available. Delete not done***\n");
        return new Result(null, Result::CODE_FAIL, 'Delete not yet available.');
    }


} 