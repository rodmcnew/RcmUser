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
use RcmUser\Model\User\Entity\DoctrineUser;
use RcmUser\Model\User\Entity\UserInterface;

class DoctrineDataMapper implements DataMapperInterface
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

    /**
     * @param $id
     *
     * @return UserInterface | Exception
     */
    public function fetchById($id)
    {
        $user = $this->getEntityManager()->find($this->getEntityClass(), $id);
        if (empty($user)) {

            return new RcmUserException('User could not be found by id.');
        }

        return $user;
    }

    /**
     * @param $username
     *
     * @return UserInterface | Exception
     */
    public function fetchByUsername($username)
    {
        $user = $this->getEntityManager()->getRepository($this->getEntityClass())->findOneBy(array('username' => $username));
        if (empty($user)) {

            return  new RcmUserException('User could not be found by username.');
        }

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function create(UserInterface $user)
    {
        $user = $this->getValidInstance($user);

        // @todo if error, fail with null, log error?
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function read(UserInterface $user)
    {
        $user = $this->getValidInstance($user);

        $id = $user->getId();
        if (!empty($id)) {

            return $this->fetchById($id);
        }

        $username = $user->getUsername();
        if (!empty($username)) {

            return $this->fetchByUsername($username);
        }

        return new RcmUserException('User could not be read.');
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function update(UserInterface $user)
    {
        $user = $this->getValidInstance($user);

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new RcmUserException('User cannot be updated, id required for update.');
        }

        // @todo if error, fail with null, log error?
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function delete(UserInterface $user)
    {
        $user = $this->getValidInstance($user);

        if (!$this->canUpdate($user)) {

            // error, cannot update
            return new RcmUserException('User cannot be updated, id required for update.');
        }
        // @todo if error, fail with null, log error?
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface | Exception
     */
    public function getValidInstance(UserInterface $user)
    {

        if (!($user instanceof DoctrineUser)) {

            $doctrineUser = new DoctrineUser();
            $doctrineUser->populate($user);

            $user = $doctrineUser;
        }

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function canUpdate(UserInterface $user)
    {

        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        return true;
    }
} 