<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Event;


use RcmUser\Event\AbstractListener;
use RcmUser\User\Db\UserRolesDataMapperInterface;

class AbstractUserDataServiceListener extends AbstractListener {

    const USER_PROPERTY_KEY = 'RcmUser\Acl\UserRoles';
    protected $listeners = array();
    protected $id = 'RcmUser\User\Service\UserDataService';
    protected $event = '';
    protected $userRolesDataMapper;
    protected $defaultRoleIdentities = array();
    protected $defaultAuthenticatedRoleIdentities = array();

    /**
     * @param mixed $userRolesDataMapper
     */
    public function setUserRolesDataMapper(UserRolesDataMapperInterface $userRolesDataMapper)
    {
        $this->userRolesDataMapper = $userRolesDataMapper;
    }

    /**
     * @return mixed
     */
    public function getUserRolesDataMapper()
    {
        return $this->userRolesDataMapper;
    }

    /**
     * @param array $defaultAuthenticatedRoleIdentities
     */
    public function setDefaultAuthenticatedRoleIdentities($defaultAuthenticatedRoleIdentities)
    {
        $this->defaultAuthenticatedRoleIdentities = $defaultAuthenticatedRoleIdentities;
    }

    /**
     * @return array
     */
    public function getDefaultAuthenticatedRoleIdentities()
    {
        return $this->defaultAuthenticatedRoleIdentities;
    }

    /**
     * @param array $defaultRoleIdentities
     */
    public function setDefaultRoleIdentities($defaultRoleIdentities)
    {
        $this->defaultRoleIdentities = $defaultRoleIdentities;
    }

    /**
     * @return array
     */
    public function getDefaultRoleIdentities()
    {
        return $this->defaultRoleIdentities;
    }
} 