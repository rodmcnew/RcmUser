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
     * @var
     */
    protected $rule;

    /**
     * @var
     */
    protected $role;

    /**
     * @var
     */
    protected $resource;

    /**
     * @var
     */
    protected $privilege;

    /**
     * setPrivilege
     *
     * @param string $privilege privilege
     *
     * @return void
     */
    public function setPrivilege($privilege)
    {
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
     * setResource
     *
     * @param string $resource resource
     *
     * @return void
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * getResource
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * setRole
     *
     * @param AclRole $role role
     *
     * @return void
     */
    public function setRole(AclRole $role)
    {
        $this->role = $role;
    }

    /**
     * getRole
     *
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * setRule
     *
     * @param string $rule rule
     *
     * @return void
     */
    public function setRule($rule)
    {
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
     * jsonSerialize
     *
     * @return \stdClass
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
     * getIterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator(get_object_vars($this));
    }

} 