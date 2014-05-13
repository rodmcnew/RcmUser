<?php
/**
 * BjyAclRoleTest.php
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
use RcmUser\Acl\Entity\BjyAclRole;
use RcmUser\Zf2TestCase;

require_once __DIR__ . '/../../../Zf2TestCase.php';

/**
 * Class BjyAclRoleTest
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
class BjyAclRoleTest extends Zf2TestCase
{

    /**
     * testSetGet
     *
     * @covers \RcmUser\Acl\Entity\BjyAclRole
     *
     * @return void
     */
    public function testSetGet()
    {
        $aclRole = new BjyAclRole();

        $proleA = 'parentA';

        $proleb = new AclRole();
        $proleb->setParentRoleId('parentB');

        $aclRole->setParentRoleId($proleA);
        $this->assertTrue(
            $aclRole->getParent() === $proleA, 'Setter or getter failed.'
        );

        $aclRole->setParentRoleId($proleb);
        $this->assertTrue(
            $aclRole->getParent() === $proleb->getRoleId(),
            'Setter or getter failed.'
        );
    }
}
 