<?php
/**
 * DoctrineAclRule.php
 *
 * DoctrineAclRule
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * DoctrineAclRule
 *
 * DoctrineAclRule
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_user_acl_rule")
 */
class DoctrineAclRule extends AclRule
{

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
     * setRoleId
     *
     * @param int $roleId role id
     *
     * @return void
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * getRoleId
     *
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * setId
     *
     * @param int $id id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

} 