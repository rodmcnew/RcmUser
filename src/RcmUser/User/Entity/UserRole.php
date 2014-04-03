<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Entity;


/**
 * Class UserRole
 *
 * @package RcmUser\User\Entity
 */
class UserRole implements UserRoleInterface
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $userId;
    /**
     * @var int
     */
    protected $roleId;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param UserRole|array $data
     *
     * @throws RcmUserException
     */
    public function populate($data = array())
    {
        if (($data instanceof UserRole)) {

            $this->setId($data->getId());
            $this->setRoleId($data->getRoleId());
            $this->setUserId($data->getUserId());

            return;
        }

        if (is_array($data)) {

            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
            if (isset($data['roleId'])) {
                $this->setRoleId($data['roleId']);
            }
            if (isset($data['userId'])) {
                $this->setUserId($data['userId']);
            }

            return;
        }

        throw new RcmUserException('User role data could not be populated, date format not supported');
    }
} 