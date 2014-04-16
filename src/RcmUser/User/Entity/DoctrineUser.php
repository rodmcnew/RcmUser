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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DoctrineUser
 *
 * @package RcmUser\User\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_user_user")
 */
class DoctrineUser extends User
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $id = null;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $state = User::STATE_DISABLED;
} 