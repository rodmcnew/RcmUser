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


interface UserInterface extends \IteratorAggregate
{

    /**
     * @param string $id
     */
    public function setId($id);

    /**
     * @param string
     */
    public function getId();

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $username
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param array $data
     *
     * @return void
     */
    public function populate($data = array());

    /**
     * @return ArrayIterator
     */
    public function getIterator();

} 