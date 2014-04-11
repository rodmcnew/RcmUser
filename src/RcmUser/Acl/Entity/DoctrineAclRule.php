<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
/**
 * Class DoctrineAclRule
 *
 * @package RcmUser\Acl\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_user_acl_rule")
 */
class DoctrineAclRule extends AclRule {

    /**
     * @var integer
     * @ORM\id
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $roleId;

    /**
     * @OneToOne(targetEntity="DoctrineAclRole")
     * @JoinColumn(name="roleId", referencedColumnName="id")
     **/
    protected $role;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $rule = AclRule::RULE_ALLOW;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $resource;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $privilege;



    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

} 