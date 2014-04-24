<?php
/**
 * ReadOnlyUser.php
 *
 * Primary User class
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Entity;


use RcmUser\Exception\RcmUserReadOnlyException;

/**
 * Class ReadOnlyUser
 *
 * Read only user class - only writable on construct
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ReadOnlyUser extends User
{
    protected $locked = false;

    public function __construct(User $user)
    {
        parent::populate($user);
        $this->locked = true;
    }

    /**
     * setId
     *
     * @param mixed $id id
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserReadOnlyException
     */
    public function setId($id)
    {
        if (!$this->locked) {

            return parent::setId($id);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }

    /**
     * setUsername
     *
     * @param string $username username
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserReadOnlyException
     */
    public function setUsername($username)
    {
        if (!$this->locked) {

            return parent::setUsername($username);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }

    /**
     * setPassword
     *
     * @param string $password password
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserReadOnlyException
     */
    public function setPassword($password)
    {
        if (!$this->locked) {

            return parent::setPassword($password);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }

    /**
     * setState
     *
     * @param string $state state
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserReadOnlyException
     */
    public function setState($state)
    {
        if (!$this->locked) {

            return parent::setState($state);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }

    /**
     * setProperties
     *
     * @param array $properties properties
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserReadOnlyException
     */
    public function setProperties($properties)
    {
        if (!$this->locked) {

            return parent::setProperties($properties);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }

    /**
     * setProperty
     *
     * @param string $key key
     * @param mixed  $val val
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserReadOnlyException
     */
    public function setProperty($key, $val)
    {
        if (!$this->locked) {

            return parent::setProperty($key, $val);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }

    /**
     * populate
     *
     * @param User|array $data    data as User or array
     * @param array      $exclude list of object properties to ignore (not populate)
     *
     * @return mixed|void
     * @throws \RcmUser\Exception\RcmUserException|\RcmUser\Exception\RcmUserReadOnlyException
     */
    public function populate($data, $exclude = array())
    {
        if (!$this->locked) {

            return parent::populate($data);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }


    /**
     * merge
     *
     * @param User $user user
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserReadOnlyException
     */
    public function merge(User $user)
    {
        if (!$this->locked) {

            return parent::merge($user);
        }

        throw new RcmUserReadOnlyException('Object is READ ONLY');
    }


}