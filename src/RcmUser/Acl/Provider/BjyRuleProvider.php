<?php
/**
 * BjyRuleProvider.php
 *
 * BjyRuleProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Rule\ProviderInterface;
use RcmUser\Acl\Db\AclRuleDataMapperInterface;
use RcmUser\Acl\Entity\AclRule;

/**
 * BjyRuleProvider
 *
 * BjyRuleProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class BjyRuleProvider implements ProviderInterface
{
    /**
     * @var
     */
    protected $ruleDataMapper;

    /**
     * setRuleDataMapper
     *
     * @param AclRuleDataMapperInterface $ruleDataMapper ruleDataMapper
     *
     * @return void
     */
    public function setRuleDataMapper(AclRuleDataMapperInterface $ruleDataMapper)
    {
        $this->ruleDataMapper = $ruleDataMapper;
    }

    /**
     * getRuleDataMapper
     *
     * @return AclRuleDataMapperInterface
     */
    public function getRuleDataMapper()
    {
        return $this->ruleDataMapper;
    }

    /**
     * getRules
     *
     * @return array
     * @throws \Exception
     */
    public function getRules()
    {

        $result = $this->getRuleDataMapper()->fetchAll();

        if (!$result->isSuccess()) {

            throw new \Exception($result->getMessage());
        }

        $rules = $this->prepareRcmRules($result->getData());

        if (empty($rules['allow'])) {

            throw new \Exception('No allow rules set, allow rules are required for any access');
        }

        return $rules;
    }

    /**
     * getAllowRules
     *
     * @return array
     */
    public function getAllowRules()
    {

        $result = $this->getRuleDataMapper()->fetchByRule(AclRule::RULE_ALLOW);

        if (!$result->isSuccess()) {

            return array();
        }

        return $this->prepareRcmRules($result->getData());
    }

    /**
     * getDenyRules
     *
     * @return array
     */
    public function getDenyRules()
    {

        $result = $this->getRuleDataMapper()->fetchByRule(AclRule::RULE_DENY);

        if (!$result->isSuccess()) {

            return array();
        }

        return $result->getData();
    }

    /**
     * prepareRcmRules
     *
     * @param array $rcmRules rcmRules
     *
     * @return array
     */
    public function prepareRcmRules($rcmRules)
    {
        $bjyRules = array('allow' => array(), 'deny' => array());

        foreach ($rcmRules as $key => $rule) {

            $ruleStr = $rule->getRule();

            if (isset($bjyRules[$ruleStr])) {

                $bjyRules[$ruleStr][$key] = array();
                $bjyRules[$ruleStr][$key][0] = $rule->getRole()->getRoleIdentity();
                $bjyRules[$ruleStr][$key][1] = $rule->getResource();
                $priv = $rule->getPrivilege();
                if (!empty($priv)) {
                    $bjyRules[$ruleStr][$key][2] = $priv;
                }
            }
        }

        return $bjyRules;
    }
}
