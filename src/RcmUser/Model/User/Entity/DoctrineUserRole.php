<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\User\Entity;


/**
 * Class DoctrineUserRole
 *
 * @package RcmUser\Model\User\Entity
 */
class DoctrineUserRole extends UserRole {

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $userId;
    /**
     * @var string
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $roleId;
} 