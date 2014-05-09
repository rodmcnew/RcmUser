<?php
/**
 * AclRuleTest.php
 *
 * TEST
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Acl\Entity;

use RcmUser\Acl\Entity\AclRole;
use RcmUser\Acl\Entity\AclRule;
use RcmUser\Zf2TestCase;

require_once __DIR__ . '/../../../Zf2TestCase.php';

/**
 * Class AclRuleTest
 *
 * TEST
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright ${YEAR} Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclRuleTest extends Zf2TestCase
{
    /**
     * testSetGet
     *
     * @covers \RcmUser\Acl\Entity\AclRule
     *
     * @return void
     */
    public function testSetGet()
    {
        $aclRule = new AclRule();
        $rule = 'allow';
        $role = new AclRole();
        $resource = 'someresource';
        $privilege = 'someprivilege';

        $aclRule->setRule($rule);
        $aclRule->setRole($role);
        $aclRule->setResource($resource);
        $aclRule->setPrivilege($privilege);

        $this->assertTrue($aclRule->getRule() === $rule, 'Setter or getter failed.');
        $this->assertTrue($aclRule->getRole() === $role, 'Setter or getter failed.');
        $this->assertTrue(
            $aclRule->getResource() === $resource, 'Setter or getter failed.'
        );
        $this->assertTrue(
            $aclRule->getPrivilege() === $privilege, 'Setter or getter failed.'
        );
    }

    /**
     * testJsonSerialize
     *
     * @covers \RcmUser\Acl\Entity\AclRule::jsonSerialize
     *
     * @return void
     */
    public function testJsonSerialize()
    {
        $aclRule = new AclRule();
        $rule = 'allow';
        $role = new AclRole();
        $resource = 'someresource';
        $privilege = 'someprivilege';

        $aclRule->setRule($rule);
        $aclRule->setRole($role);
        $aclRule->setResource($resource);
        $aclRule->setPrivilege($privilege);

        $aclRuleJson = json_encode($aclRule);

        $this->assertJson($aclRuleJson, 'User not converted to JSON.');
    }

    /**
     * testArrayIterator
     *
     * @covers \RcmUser\Acl\Entity\AclRule::getIterator
     *
     * @return void
     */
    public function testArrayIterator()
    {
        $aclRule = new AclRule();
        $rule = 'allow';
        $role = new AclRole();
        $resource = 'someresource';
        $privilege = 'someprivilege';

        $aclRule->setRule($rule);
        $aclRule->setRole($role);
        $aclRule->setResource($resource);
        $aclRule->setPrivilege($privilege);

        $iter = $aclRule->getIterator();
        $array1 = iterator_to_array($aclRule);
        $array2 = iterator_to_array($iter);

        $this->assertTrue($array1 == $array2, 'Iterator failed work.');

        $this->assertTrue(is_array($array1), 'Iterator failed work.');

        $this->assertArrayHasKey(
            'rule', $array1, 'Iterator did not populate correctly.'
        );
    }
}
 