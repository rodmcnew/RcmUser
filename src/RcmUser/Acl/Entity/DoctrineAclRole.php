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

/**
 * Class DoctrineAclRole
 *
 * @package RcmUser\User\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_user_acl_role")
 */
class DoctrineAclRole extends AclRole {
    /**
     * @var integer
     * @ORM\Id
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
} 