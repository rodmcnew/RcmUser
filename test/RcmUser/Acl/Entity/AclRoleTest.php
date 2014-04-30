<?php
 /**
 * AclRoleTest.php
 *
 * LongDescHere
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
use RcmUser\Exception\RcmUserException;
use RcmUser\Zf2TestCase;

require_once __DIR__ . '/../../../Zf2TestCase.php';

class AclRoleTest extends Zf2TestCase
{

    /**
     * testSetGet
     *
     * @covers \RcmUser\Acl\Entity\AclRole
     *
     * @return void
     */
    public function testSetGet()
    {
        $aclRole = new AclRole();
        $role = 'testrole';
        $prole = 'parenttestrole';
        $desc = 'Descript';
        $aclRole->setRoleIdentity($role);
        $aclRole->setParentRole($prole);
        $aclRole->setDescription($desc);

        $this->assertTrue($aclRole->getRoleIdentity() === $role, 'Setter or getter failed.');
        $this->assertTrue($aclRole->getRoleId() === $role, 'Setter or getter failed.');
        $this->assertTrue($aclRole->getParentRole() === $prole, 'Setter or getter failed.');
        $this->assertTrue($aclRole->getParent() === $prole, 'Setter or getter failed.');
        $this->assertTrue($aclRole->getDescription() === $desc, 'Setter or getter failed.');
    }

    /**
     * testPopulate
     *
     * @covers \RcmUser\Acl\Entity\AclRole::populate
     *
     * @return void
     */
    public function testPopulate()
    {
        $aclRole = new AclRole();
        $aclRoleA = array(
            'roleIdentity' => 'arrayRoleA',
            'parentRole' => 'arrayRoleA',
            'description' => 'arrayRoleA',
        );
        $aclRoleB = new AclRole();
        $aclRoleB->setRoleIdentity('roleB');
        $aclRoleB->setParentRole('roleB');
        $aclRoleB->setDescription('roleB');

        $aclRoleC = 'wrong format';

        $aclRole->populate($aclRoleA);

        $this->assertTrue($aclRole->getRoleIdentity() === 'arrayRoleA', 'Setter or getter failed.');

        $aclRole->populate($aclRoleB);

        $this->assertTrue($aclRole->getRoleIdentity() === 'roleB', 'Setter or getter failed.');

        try{
            $aclRole->populate($aclRoleC);

        }catch(RcmUserException $e){

            $this->assertInstanceOf('\RcmUser\Exception\RcmUserException', $e);
            return;
        }

        $this->fail("Expected exception not thrown");
    }

    /**
     * testJsonSerialize
     *
     * @covers \RcmUser\Acl\Entity\AclRole::jsonSerialize
     *
     * @return void
     */
    public function testJsonSerialize()
    {
        $aclRole = new AclRole();
        $aclRole->setRoleIdentity('role');
        $aclRole->setParentRole('role');
        $aclRole->setDescription('role');

        $aclRoleJson = json_encode($aclRole);

        $this->assertJson($aclRoleJson, 'User not converted to JSON.');
    }

    /**
     * testArrayIterator
     *
     * @covers \RcmUser\Acl\Entity\AclRole::getIterator
     *
     * @return void
     */
    public function testArrayIterator()
    {
        $aclRole = new AclRole();
        $aclRole->setRoleIdentity('role');
        $aclRole->setParentRole('role');
        $aclRole->setDescription('role');

        $iter = $aclRole->getIterator();
        $aclRoleArr = iterator_to_array($aclRole);
        $aclRoleArr2 = iterator_to_array($iter);

        $this->assertTrue($aclRoleArr == $aclRoleArr2, 'Iterator failed work.');

        $this->assertTrue(is_array($aclRoleArr), 'Iterator failed work.');

        $this->assertArrayHasKey(
            'roleIdentity', $aclRoleArr, 'Iterator did not populate correctly.'
        );
    }
}
 