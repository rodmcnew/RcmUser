<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Db;


use RcmUser\Acl\Entity\AclRule;
use RcmUser\Db\DoctrineMapper;
use Doctrine\ORM\QueryBuilder;
use RcmUser\Result;

/**
 * Class DoctrineAclRuleDataMapper
 *
 * @package RcmUser\Acl\Db
 */
class DoctrineAclRuleDataMapper extends DoctrineMapper implements AclRuleDataMapperInterface
{


    /**
     * @return Result
     */
    public function fetchAll()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT rule FROM ' . $this->getEntityClass() . ' rule '.
            'INDEX BY rule.id'
        );

        $rules = $query->getResult();

        if (empty($rules)) {

            return new Result(null, Result::CODE_FAIL, 'Rules could not be found.');
        }

        return new Result($rules);
    }

    /**
     * @param int $id
     *
     * @return Result
     */
    public function fetchById($id)
    {
    }

    /**
     * @param $parentId
     *
     * @return Result
     */
    public function fetchByParentId($parentId)
    {
    }

    /**
     * @param $roleId
     *
     * @return Result
     */
    public function fetchByRole($roleId)
    {
    }


    public function fetchByRule($rule = AclRule::RULE_ALLOW)
    {

        $rules = $this->getEntityManager()->getRepository($this->getEntityClass())->findBy(array('rule' => $rule));

        /*
        $query = $this->getEntityManager()->createQuery('
            SELECT role FROM '.$this->getEntityClass().' rule
            INDEX BY rule.rule'
        );

        $rules = $query->getResult();
        */

        if (empty($rules)) {

            return new Result(null, Result::CODE_FAIL, 'Rules could not be found.');
        }

        return new Result($rules);
    }

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function create(AclRule $aclRule)
    {
    }

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function read(AclRule $aclRule)
    {
    }

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function update(AclRule $aclRule)
    {
    }

    /**
     * @param AclRule $aclRule
     *
     * @return Result
     */
    public function delete(AclRule $aclRule)
    {
    }
} 