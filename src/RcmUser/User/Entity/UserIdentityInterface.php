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


interface UserIdentityInterface {

    /**
     * @param mixed $password
     */
    public function setPassword($password);

    /**
     * @return mixed
     */
    public function getPassword();

    /**
     * @param mixed $username
     */
    public function setUsername($username);

    /**
     * @return mixed
     */
    public function getUsername();

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid);

    /**
     * @return mixed
     */
    public function getUuid();


} 