<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Acl\Event;


use RcmUser\Model\Event\AbstractListener;
use RcmUser\Model\User\Db\UserRolesDataMapperInterface;

class AbstractUserDataServiceListener extends AbstractListener {

    protected $listeners = array();
    protected $id = 'RcmUser\Service\RcmUserDataService';
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