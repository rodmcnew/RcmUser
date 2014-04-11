<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Entity;


class AclRule implements \JsonSerializable, \IteratorAggregate
{

    const RULE_ALLOW = 'allow';
    const RULE_DENY = 'deny';
    const RULE_IGNORE = 'ignore'; // this rule is a way of disabling a rule without deleting it

    protected $rule;

    protected $role;

    protected $resource;

    protected $privilege;

    /**
     * @param mixed $privilege
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
    }

    /**
     * @return mixed
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param string $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param AclRole $role
     */
    public function setRole(AclRole $role)
    {
        $this->role = $role;
    }

    /**
     * @return AclRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $rule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }

    /**
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @return stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->rule = $this->getRule();
        $obj->role = $this->getrole();
        $obj->resource = $this->getResource();
        $obj->privilege = $this->getPrivilege();

        return $obj;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator(get_object_vars($this));
    }

} 