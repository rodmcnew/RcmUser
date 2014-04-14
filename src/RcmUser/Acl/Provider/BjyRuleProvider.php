<?php
/**
 *
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Rule\ProviderInterface;
use RcmUser\Acl\Db\AclRuleDataMapperInterface;
use RcmUser\Acl\Entity\AclRule;

/**
 *
 */
class BjyRuleProvider implements ProviderInterface
{
    protected $ruleDataMapper;

    /**
     * @param AclRuleDataMapperInterface $ruleDataMapper
     */
    public function setRuleDataMapper(AclRuleDataMapperInterface $ruleDataMapper)
    {
        $this->ruleDataMapper = $ruleDataMapper;
    }

    /**
     * @return AclRuleDataMapperInterface
     */
    public function getRuleDataMapper()
    {
        return $this->ruleDataMapper;
    }

    /**
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

    public function getAllowRules()
    {

        $result = $this->getRuleDataMapper()->fetchByRule(AclRule::RULE_ALLOW);

        if (!$result->isSuccess()) {

            return array();
        }

        return $this->prepareRcmRules($result->getData());
    }

    public function getDenyRules()
    {

        $result = $this->getRuleDataMapper()->fetchByRule(AclRule::RULE_DENY);

        if (!$result->isSuccess()) {

            return array();
        }

        return $result->getData();
    }

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
