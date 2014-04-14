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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Class DoctrineAclRole
 *
 * @package RcmUser\User\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_user_acl_role")
 */
class DoctrineAclRole extends BjyAclRole
{

    const ROLE_ROOT_ID = 0;

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
    protected $parentId;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $roleIdentity;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @todo This can probably be made to work
     * -- Needs to accept 0 value if this is in the root of the tree
     * -- needs to only nest the parent, not the whole parent tree
     * OneToOne(targetEntity="DoctrineAclRole")
     * JoinColumn(name="parentId", referencedColumnName="id")
     **/
    protected $parentRole;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }
} 