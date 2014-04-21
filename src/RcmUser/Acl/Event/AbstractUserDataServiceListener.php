<?php
/**
 * AbstractUserDataServiceListener.php
 *
 * AbstractUserDataServiceListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Event;


use RcmUser\Event\AbstractListener;
use RcmUser\User\Db\UserRolesDataMapperInterface;

/**
 * AbstractUserDataServiceListener
 *
 * AbstractUserDataServiceListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractUserDataServiceListener extends AbstractListener
{

    /**
     * @var array
     */
    protected $listeners = array();
    /**
     * @var string
     */
    protected $id = 'RcmUser\User\Service\UserDataService';
    /**
     * @var string
     */
    protected $event = '';
    /**
     * @var
     */
    protected $userRolesDataMapper;
    /**
     * @var array
     */
    protected $defaultRoleIdentities = array();
    /**
     * @var array
     */
    protected $defaultAuthenticatedRoleIdentities = array();

    /**
     * @var string
     */
    protected $userPropertyKey = 'RcmUser\Acl\UserRoles';

    /**
     * setUserRolesDataMapper
     *
     * @param UserRolesDataMapperInterface $userRolesDataMapper userRolesDataMapper
     *
     * @return void
     */
    public function setUserRolesDataMapper(
        UserRolesDataMapperInterface $userRolesDataMapper
    ) {
        $this->userRolesDataMapper = $userRolesDataMapper;
    }

    /**
     * getUserRolesDataMapper
     *
     * @return UserRolesDataMapperInterface
     */
    public function getUserRolesDataMapper()
    {
        return $this->userRolesDataMapper;
    }

    /**
     * setDefaultAuthenticatedRoleIdentities
     *
     * @param array $defaultAuthenticatedRoleIdentities default auth identity strings
     *
     * @return void
     */
    public function setDefaultAuthenticatedRoleIdentities(
        $defaultAuthenticatedRoleIdentities
    ) {
        $this->defaultAuthenticatedRoleIdentities
            = $defaultAuthenticatedRoleIdentities;
    }

    /**
     * getDefaultAuthenticatedRoleIdentities
     *
     * @return array
     */
    public function getDefaultAuthenticatedRoleIdentities()
    {
        return $this->defaultAuthenticatedRoleIdentities;
    }

    /**
     * setDefaultRoleIdentities
     *
     * @param array $defaultRoleIdentities default roles identity strings
     *
     * @return void
     */
    public function setDefaultRoleIdentities($defaultRoleIdentities)
    {
        $this->defaultRoleIdentities = $defaultRoleIdentities;
    }

    /**
     * getDefaultRoleIdentities
     *
     * @return array
     */
    public function getDefaultRoleIdentities()
    {
        return $this->defaultRoleIdentities;
    }

    /**
     * setUserPropertyKey
     *
     * @param string $userPropertyKey user property key
     *
     * @return void
     */
    public function setUserPropertyKey($userPropertyKey)
    {
        $this->userPropertyKey = $userPropertyKey;
    }

    /**
     * getUserPropertyKey
     *
     * @return string
     */
    public function getUserPropertyKey()
    {
        return $this->userPropertyKey;
    }
} 