<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\User\Db;


use Doctrine\ORM\EntityManager;
use RcmUser\Model\Acl\Entity\Role;
use RcmUser\Model\User\Entity\UserInterface;
use RcmUser\Model\User\Result;

class DoctrineUserRolesDataMapper implements UserRolesDataMapperInterface
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
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {

        return $this->entityManager;
    }

    /**
     * @param mixed $entityClass
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = (string)$entityClass;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function add(UserInterface $user, Role $role)
    {

    }

    public function remove(UserInterface $user, Role $role)
    {

    }

    public function create(UserInterface $user, $roles = array())
    {

    }

    public function read(UserInterface $user)
    {
        return array('me','and','doctrine');
    }

    public function update(UserInterface $user, $roles = array())
    {
    }

    public function delete(UserInterface $user)
    {
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function getValidUserInstance(UserInterface $user)
    {

        if (!($user instanceof DoctrineUser)) {

            $doctrineUser = new DoctrineUser();
            $doctrineUser->populate($user);

            $user = $doctrineUser;
        }

        return new Result($user);
    }
} 