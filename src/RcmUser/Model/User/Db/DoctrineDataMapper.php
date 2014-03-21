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
     * @return mixed
     */
    public function fetchById($id)
    {
        return $this->getEntityManager()->find($this->getEntityClass(), $id);
    }

    /**
     * @param $username
     *
     * @return mixed
     */
    public function fetchByUsername($username)
    {
        return $this->getEntityManager()->findOneBy($this->getEntityClass(), array('username' => $username));
    }

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function fetch(UserInterface $user)
    {
        $id = $user->getId();
        if(!empty($id)){

            return $this->getById($id);
        }

        $username = $user->getUsername();
        if(!empty($username)){

            return $this->getById($username);
        }

        return null;
    }

    public function store(UserInterface $user)
    {
        // @todo DoctrineUser should have abstract
        if (!($user instanceof DoctrineUser)) {

            $doctrineUser = new DoctrineUser();
            $doctrineUser->populate($user);
            $user = $doctrineUser;
        }

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return null;
    }
} 