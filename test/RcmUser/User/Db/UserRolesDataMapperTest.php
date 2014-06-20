<?php
/**
 * UserRolesDataMapperTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\User\Db;

require_once __DIR__ . '/../../../Zf2TestCase.php';

use RcmUser\User\Db\UserRolesDataMapper;

/**
 * Class UserRolesDataMapperTest
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright ${YEAR} Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserRolesDataMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserRolesDataMapper $userRolesDataMapper
     */
    public $userRolesDataMapper;
    /**
     * setup
     *
     * @return void
     */
    public function setup()
    {
        $this->roles = array('someroles');

        $this->aclRoleDataMapper = $this->getMockBuilder(
            'RcmUser\Acl\Db\AclRoleDataMapperInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->aclRoleDataMapper->expects($this->any())
            ->method('fetchAll')
            ->will($this->returnValue($this->roles));


        $this->userRolesDataMapper
            = new UserRolesDataMapper($this->aclRoleDataMapper);

        $this->user = new User('123');
        $this->user->setUsername('testuser');
    }

    /**
     * test
     *
     * @return void
     */
    public function test()
    {
        $this->assertEquals(
            $this->aclRoleDataMapper,
            $this->userRolesDataMapper->getAclRoleDataMapper()
        );

        $this->assertEquals(
            $this->roles,
            $this->userRolesDataMapper->getAvailableRoles()
        );
    }

    /**
     * testFetchAll
     *
     * @expectedException \RcmUser\Exception\RcmUserException
     *
     * @return void
     */
    public function testFetchAll()
    {
        $result = $this->userDataMapper->fetchAll(
            $this->user,
            'roleId'
        );
    }

    
}
 