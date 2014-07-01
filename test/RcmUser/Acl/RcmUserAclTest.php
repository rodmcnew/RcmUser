<?php
 /**
 * RcmUserAclTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Acl
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Acl;

use RcmUser\Acl\Entity\AclResource;
use RcmUser\Acl\Entity\AclRole;
use RcmUser\Acl\RcmUserAcl;
use RcmUser\Zf2TestCase;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;

require_once __DIR__ . '/../../Zf2TestCase.php';


class RcmUserAclTest extends Zf2TestCase {

    public function testGetAccess(){

        $acl = new RcmUserAcl();

        $acl->addRole(new AclRole('guest'))
            ->addRole(new AclRole('member'))
            ->addRole(new AclRole('admin'));

        $parents = array('guest', 'member', 'admin');
        $acl->addRole(new AclRole('someUser'), $parents);

        $acl->addResource(new AclResource('someresource'));

        $acl->deny('guest', 'someresource');
        $acl->allow('member', 'someresource');

        //echo "\n*** RESULT: " .
        //var_export($acl->getAccess('someUser', 'someresource'), true);
    }

}
 