<?php
/**
 * DoctrineAclRuleDataMapper.php
 *
 * DoctrineAclRuleDataMapper
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
use RcmUser\Acl\Entity\AclRule;
use RcmUser\Acl\Entity\DoctrineAclRule;
use RcmUser\Db\DoctrineMapperInterface;
use RcmUser\Result;

/**
 * DoctrineAclRuleDataMapper
 *
 * DoctrineAclRuleDataMapper
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
class DoctrineAclRuleDataMapper
    extends AclRuleDataMapper
    implements AclRuleDataMapperInterface, DoctrineMapperInterface
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var string $entityClass
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
     * @return Result
     */
    public function fetchAll()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT rule FROM ' . $this->getEntityClass() . ' rule ' .
            'INDEX BY rule.id'
        );

        $rules = $query->getResult();

        if (empty($rules)) {

            return new Result(null, Result::CODE_FAIL, 'Rules could not be found.');
        }

        return new Result($rules);
    }

    /**
     * fetchByRole
     *
     * @param string $roleId the roleId
     *
     * @return Result
     */
    public function fetchByRole($roleId)
    {
        $rules = $this->getEntityManager()->getRepository($this->getEntityClass())
            ->findBy(array('roleId' => $roleId));

        if (empty($rules)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'Rules could not be found by role Id.'
            );
        }

        return new Result($rules);
    }

    /**
     * fetchByRule
     *
     * @param AclRule|string $rule rule
     *
     * @return Result|Result
     */
    public function fetchByRule($rule = AclRule::RULE_ALLOW)
    {
        $rules = $this->getEntityManager()->getRepository($this->getEntityClass())
            ->findBy(array('rule' => $rule));

        if (empty($rules)) {

            return new Result(null, Result::CODE_FAIL, 'Rules could not be found.');
        }

        return new Result($rules);
    }

    /**
     * fetchByResource
     *
     * @param string $resourceId resourceId
     *
     * @return mixed|Result
     */
    public function fetchByResource($resourceId)
    {
        //$rules = $this->getEntityManager()->getRepository($this->getEntityClass())
        //    ->findBy(array('resource' => $resourceId));

        $query = $this->getEntityManager()->createQuery(
            'SELECT rule FROM ' . $this->getEntityClass() . ' rule ' .
            'INDEX BY rule.id ' .
            'WHERE rule.resource = ?1'
        );

        $query->setParameter(1, $resourceId);

        $rules = $query->getResult();

        if (empty($rules)) {

            return new Result(
                null,
                Result::CODE_FAIL,
                'Rules could not be found by resource.'
            );
        }

        return new Result($rules);
    }

    /**
     * create
     *
     * @param AclRule $aclRule the aclRule
     *
     * @return Result
     */
    public function create(AclRule $aclRule)
    {
        $result = $this->getValidInstance($aclRule);

        $aclRule = $result->getData();

        // @todo if error, fail with null
        $this->getEntityManager()->persist($aclRule);
        $this->getEntityManager()->flush();

        return new Result($aclRule);
    }

    /**
     * read
     *
     * @param AclRule $aclRule the aclRule
     *
     * @return Result
     */
    public function read(AclRule $aclRule)
    {
        // todo write me
        parent::read($aclRule);
    }

    /**
     * update
     *
     * @param AclRule $aclRule the aclRule
     *
     * @return Result
     */
    public function update(AclRule $aclRule)
    {
        // todo write me
        parent::update($aclRule);
    }

    /**
     * delete
     *
     * @param AclRule $aclRule the aclRule
     *
     * @return Result
     */
    public function delete(AclRule $aclRule)
    {
        // todo write me
        parent::delete($aclRule);
    }


    public function getValidInstance(AclRule $aclRule)
    {
        if (!($aclRule instanceof DoctrineAclRule)) {

            $doctrineAclRole = new DoctrineAclRule();
            $doctrineAclRole->populate($aclRule);

            $aclRule = $doctrineAclRole;
        }

        return new Result($aclRule);
    }

} 