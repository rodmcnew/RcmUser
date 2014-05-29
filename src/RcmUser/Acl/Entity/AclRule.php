<?php
/**
 * AclRole.php
 *
 * AclRole
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Entity;

use RcmUser\Exception\RcmUserException;
//\Zend\Permissions\Acl\Assertion\AssertionInterface

/**
 * AclRule
 *
 * AclRule entity
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclRule implements \JsonSerializable, \IteratorAggregate
{
    /**
     * string
     */
    const RULE_ALLOW = 'allow';
    /**
     * string
     */
    const RULE_DENY = 'deny';
    /**
     * string
     * this rule is a way of disabling a rule without deleting it
     */
    const RULE_IGNORE = 'ignore';

    /**
     * @var string
     */
    protected $rule = null;

    /**
     * @var string
     */
    protected $roleId = null;

    /**
     * @var string
     */
    protected $resourceId = null;

    /**
     * @var string
     */
    protected $privilege = null;

    /**
     * @var AssertionInterface/string $assertion
     */
    protected $assertion = null;

    /**
     * setRule
     *
     * @param string $rule rule
     *
     * @return void
     * @throws RcmUserException
     */
    public function setRule($rule)
    {
        if (!$this->isValidRule($rule)) {
            throw new RcmUserException(
                "Rule ({$rule}) is invalid."
            );
        }

        $this->rule = $rule;
    }

    /**
     * getRule
     *
     * @return mixed
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * setRoleId
     *
     * @param string $roleId roleId
     *
     * @return void
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * getRoleId
     *
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * setResourceId
     *
     * @param string $resourceId resourceId
     *
     * @return void
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;
    }

    /**
     * getResource
     *
     * @return string
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * setPrivilege
     *
     * @param string $privilege privilege
     *
     * @return void
     */
    public function setPrivilege($privilege)
    {
        if (empty($privilege)) {
            $privilege = null;
        }

        $this->privilege = $privilege;
    }

    /**
     * getPrivilege
     *
     * @return string
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * setAssertion
     *
     * @param AssertionInterface\string $assertion assertion
     *
     * @return void
     */
    public function setAssertion($assertion)
    {
        $this->assertion = $assertion;
    }

    /**
     * getAssertion
     *
     * @return AssertionInterface/string
     */
    public function getAssertion()
    {
        return $this->assertion;
    }

    /**
     * isValidRule
     *
     * @param string $rule rule
     *
     * @return bool
     */
    public function isValidRule($rule)
    {
        if ($rule == self::RULE_ALLOW
            || $rule == self::RULE_DENY
            || $rule == self::RULE_IGNORE
        ) {
            return true;
        }

        return false;
    }

    /**
     * populate
     *
     * @param array|AclRule $data data
     *
     * @return void
     * @throws RcmUserException
     */
    public function populate($data = array())
    {
        if (($data instanceof AclRule)) {

            $this->setRule($data->getRule());
            $this->setRoleId($data->getRoleId());
            $this->setResourceId($data->getResourceId());
            $this->setPrivilege($data->getPrivilege());
            $this->setAssertion($data->getAssertion());

            return;
        }

        if (is_array($data)) {
            if (isset($data['rule'])) {
                $this->setRule($data['rule']);
            }
            if (isset($data['roleId'])) {
                $this->setRoleId($data['roleId']);
            }
            if (isset($data['resourceId'])) {
                $this->setResourceId($data['resourceId']);
            }
            if (isset($data['privilege'])) {
                $this->setPrivilege($data['privilege']);
            }
            if (isset($data['assertion'])) {
                $this->setAssertion($data['assertion']);
            }

            return;
        }

        throw new RcmUserException(
            'Rule data could not be populated, data format not supported'
        );
    }

    /**
     * jsonSerialize
     *
     * @return \stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->rule = $this->getRule();
        $obj->roleId = $this->getRoleId();
        $obj->resourceId = $this->getResourceId();
        $obj->privilege = $this->getPrivilege();

        return $obj;
    }

    /**
     * getIterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator(get_object_vars($this));
    }

} 