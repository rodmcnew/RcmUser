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


use RcmUser\Acl\Entity\AclRule;
use RcmUser\Db\DoctrineMapper;
use Doctrine\ORM\QueryBuilder;
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
    extends DoctrineMapper
    implements AclRuleDataMapperInterface
{

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
     * fetchById
     *
     * @param int $id the id
     *
     * @return Result
     */
    public function fetchById($id)
    {
    }

    /**
     * fetchByRole
     *
     * @param string $roleId the roleIdentity
     *
     * @return Result
     */
    public function fetchByRole($roleId)
    {
    }


    /**
     * fetchByRule
     *
     * @param string $rule the rule
     *
     * @return Result
     */
    public function fetchByRule($rule = AclRule::RULE_ALLOW)
    {

        $rules = $this->getEntityManager()->getRepository($this->getEntityClass())
            ->findBy(array('rule' => $rule));

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
     * create
     *
     * @param AclRule $aclRule the aclRule
     *
     * @return Result
     */
    public function create(AclRule $aclRule)
    {
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
    }
} 