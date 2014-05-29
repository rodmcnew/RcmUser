<?php
/**
 * UserRolePropertyService.php
 *
 * UserRolePropertyService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Service;


use RcmUser\User\Db\UserRolesDataMapperInterface;
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;

/**
 * Class UserRolePropertyService
 *
 * UserRolePropertyService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserRolePropertyService
{
    /**
     * @var array $defaultGuestRoleIds
     */
    protected $defaultGuestRoleIds = array();

    /**
     * @var array $defaultUserRoleIds
     */
    protected $defaultUserRoleIds = array();

    /**
     * @var UserRolesDataMapperInterface
     */
    protected $userRolesDataMapper;

    /**
     * __construct
     *
     * @param UserRolesDataMapperInterface $userRolesDataMapper
     * @param array                         $defaultGuestRoleIds
     * @param array                         $defaultUserRoleIds
     */
    public function __construct(
        UserRolesDataMapperInterface $userRolesDataMapper,
        $defaultGuestRoleIds = array(),
        $defaultUserRoleIds = array()
    ) {

        $this->userRolesDataMapper = $userRolesDataMapper;
        $this->defaultGuestRoleIds = $defaultGuestRoleIds;
        $this->defaultUserRoleIds = $defaultUserRoleIds;
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
     * getDefaultGuestRoleIds
     *
     * @return array
     */
    public function getDefaultGuestRoleIds()
    {
        return $this->defaultGuestRoleIds;
    }

    /**
     * getDefaultUserRoleIds
     *
     * @return array
     */
    public function getDefaultUserRoleIds()
    {
        return $this->defaultUserRoleIds;
    }

    /**
     * getGuestRoleId
     *
     * @return string|null
     */
    public function getGuestRoleId()
    {
        return $this->getUserRolesDataMapper()->getGuestRoleId();
    }

    /**
     * getSuperAdminRoleId
     *
     * @return null|string
     */
    public function getSuperAdminRoleId()
    {
        return $this->getUserRolesDataMapper()->getSuperAdminRoleId();
    }

    /**
     * isGuest
     *
     * @param array $roles roles
     *
     * @return bool
     */
    public function isGuest($roles)
    {
        $key = array_search($this->getGuestRoleId(), $roles);

        /**
         * If we have the guest role and only the guest role;
         */
        if ($key !== false && (count($roles) < 2)) {

            return true;
        }

        return false;
    }

    /**
     * isSuperAdmin
     *
     * @param array $roles roles
     *
     * @return bool
     */
    public function isSuperAdmin($roles)
    {
        $key = array_search($this->getSuperAdminRoleId(), $roles);

        if ($key !== false) {

            return true;
        }

        return false;
    }

    /**
     * addRole
     *
     * @param User   $user      user
     * @param string $aclRoleId aclRoleId
     *
     * @return \RcmUser\User\Db\Result
     */
    public function addRole(User $user, $aclRoleId)
    {
        return $this->getUserRolesDataMapper()->add($user, $aclRoleId);
    }

    /**
     * remove
     *
     * @param User    $user      user
     * @param string  $aclRoleId aclRoleId
     *
     * @return Result
     */
    public function removeRole(User $user, $aclRoleId)
    {
        return $this->getUserRolesDataMapper()->remove($user, $aclRoleId);
    }

    /**
     * buildUserRoleProperty
     *
     * @param array $roles roles
     *
     * @return UserRoleProperty
     */
    protected function buildUserRoleProperty($roles)
    {
        return new UserRoleProperty(
            $roles,
            $this->isGuest($roles),
            $this->isSuperAdmin($roles)
        );
    }

    /**
     * buildDefaultRoleProperty
     *
     * @param User $user user
     *
     * @return array
     */
    public function buildDefaultRoleProperty(User $user)
    {
        $roles = $user->getProperty(
            $this->getUserPropertyKey(),
            null
        );

        if (!empty($roles)) {

            return $user;
        }

        if (empty($user->getId())) {

            $roles = $this->getDefaultRoleIdentities();
        } else {

            $roles = $this->getDefaultAuthenticatedRoleIdentities();
        }

        $user->setProperty(
            $this->getUserPropertyKey(),
            $this->buildUserRoleProperty($roles)
        );

        return $user;
    }

} 