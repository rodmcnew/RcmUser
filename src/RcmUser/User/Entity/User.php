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


use RcmUser\Exception\RcmUserException;

class User implements UserInterface, \JsonSerializable
{
    const PASSWORD_OBFUSCATE = null;
    // At the core, we only care if the user is disabled,
    // any other value means enabled and the value is up to the implementation
    const STATE_DISABLED = 'disabled';

    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $username = null;

    /**
     * @var string
     */
    protected $password = null;

    /**
     * @var string
     */
    protected $state = self::STATE_DISABLED;

    /**
     * Property data injected by external sources
     *
     * @var array
     */
    protected $properties = array();

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param $key
     * @param $val
     */
    public function setProperty($key, $val)
    {
        $this->properties[$key] = $val;
    }

    /**
     * @param      $key
     * @param null $def
     *
     * @return null
     */
    public function getProperty($key, $def = null)
    {
        if (array_key_exists($key, $this->properties)) {

            return $this->properties[$key];
        }

        return $def;
    }

    /**
     * @param array $data
     *
     * @throws RcmUserException
     */

    public function populate($data = array())
    {
        if (($data instanceof UserInterface)) {

            $this->setId($data->getId());
            $this->setUsername($data->getUsername());
            $this->setPassword($data->getPassword());
            $this->setProperties($data->getProperties());

            return;
        }

        if (is_array($data)) {

            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
            if (isset($data['username'])) {
                $this->setUsername($data['username']);
            }
            if (isset($data['password'])) {
                $this->setPassword($data['password']);
            }
            if (isset($data['properties'])) {
                $this->setProperties($data['properties']);
            }

            return;
        }

        throw new RcmUserException('User data could not be populated, data format not supported');
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {

        return new \ArrayIterator(get_object_vars($this));
    }

    /**
     * @return mixed|\stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->id = $this->getId();
        $obj->username = $this->getUsername();
        $obj->password = self::PASSWORD_OBFUSCATE; // Might be better way to obfuscate
        $obj->properties = $this->getProperties();

        return $obj;
    }


}