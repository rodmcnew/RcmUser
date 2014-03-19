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
 * Class User
 *
 * @package RcmUser\User\Entity
 */
class AbstractUser implements UserInterface {

    /**
     * @var string
     */
    protected $uuid;

    /**
     * Flag so we can tell when a user is saved to permanent storage
     * @var bool
     */
    protected $saved = false;

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = (string)$uuid;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param boolean $saved
     */
    public function setSaved($saved)
    {

        $this->saved = (bool)$saved;
    }

    /**
     * @return boolean
     */
    public function isSaved()
    {
        return (bool)$this->saved;
    }
} 