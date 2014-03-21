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
 * Class DoctrineUser
 *
 * @package RcmUser\Model\User\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_user_user")
 */
class DoctrineUser extends AbstractUser {

    /**
     * @var string
     * @Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $id = null;

    /**
     * @var string
     * @Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $username;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $password;
} 