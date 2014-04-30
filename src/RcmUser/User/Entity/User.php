<?php
/**
 * User.php
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


use RcmUser\Exception\RcmUserException;

/**
 * Class User
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
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class User implements UserInterface, \JsonSerializable
{
    /**
     * PASSWORD_OBFUSCATE
     */
    const PASSWORD_OBFUSCATE = null;
    /**
     * At the core, we only care if the user is disabled,
     * any other value means enabled and the value is up to the implementation
     */
    const STATE_DISABLED = 'disabled';

    /**
     * @var mixed $id
     */
    protected $id = null;

    /**
     * @var string $username
     */
    protected $username = null;

    /**
     * @var string $password
     */
    protected $password = null;

    /**
     * @var string $state
     */
    protected $state = null;

    /**
     * Property data injected by external sources
     *
     * @var array $properties
     */
    protected $properties = array();

    /**
     * __construct
     *
     * @param null $id id
     */
    public function __construct($id = null)
    {
        $this->setId($id);
    }
    /**
     * setId
     *
     * @param mixed $id id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * getId
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * setUsername
     *
     * @param string $username username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * getUsername
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * setPassword
     *
     * @param string $password password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * getPassword
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * setState
     *
     * @param string $state state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * getState
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * setProperties
     *
     * @param array $properties properties
     *
     * @return void
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * getProperties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * setProperty
     *
     * @param string $key key
     * @param mixed  $val val
     *
     * @return void
     */
    public function setProperty($key, $val)
    {
        $this->properties[$key] = $val;
    }

    /**
     * getProperty
     *
     * @param string $key key
     * @param null   $def def
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
     * isEnabled - Any state that is not disabled is considered enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getState() !== self::STATE_DISABLED;
    }

    /**
     * populate
     *
     * @param User|array $data    data as User or array
     * @param array      $exclude list of object properties to ignore (not populate)
     *
     * @return mixed|void
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function populate($data, $exclude = array())
    {
        if (($data instanceof UserInterface)) {

            if (!in_array('id', $exclude)) {
                $this->setId($data->getId());
            }
            if (!in_array('username', $exclude)) {
                $this->setUsername($data->getUsername());
            }
            if (!in_array('password', $exclude)) {
                $this->setPassword($data->getPassword());
            }
            if (!in_array('state', $exclude)) {
                $this->setState($data->getState());
            }
            if (!in_array('properties', $exclude)) {
                $this->setProperties($data->getProperties());
            }

            return;
        }

        if (is_array($data)) {

            if (isset($data['id']) && !in_array('id', $exclude)) {
                $this->setId($data['id']);
            }
            if (isset($data['username']) && !in_array('username', $exclude)) {
                $this->setUsername($data['username']);
            }
            if (isset($data['password']) && !in_array('password', $exclude)) {
                $this->setPassword($data['password']);
            }
            if (isset($data['state']) && !in_array('state', $exclude)) {
                $this->setState($data['state']);
            }
            if (isset($data['properties']) && !in_array('properties', $exclude)) {
                $this->setProperties($data['properties']);
            }

            return;
        }

        throw new RcmUserException(
            'User data could not be populated, data format not supported'
        );
    }

    /**
     * getIterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator(get_object_vars($this));
    }

    /**
     * jsonSerialize
     *
     * @return \stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->id = $this->getId();
        $obj->username = $this->getUsername();
        $obj->password
            = self::PASSWORD_OBFUSCATE; // Might be better way to obfuscate
        $obj->state = $this->getState();
        $obj->properties = $this->getProperties();

        return $obj;
    }

    /**
     * Merges values of the $user arg into this user if the values are not set
     *
     * @param User $user user
     *
     * @return void
     */
    public function merge(User $user)
    {
        if ($this->getId() === null) {

            $this->setId($user->getId());
        }

        if ($this->getUsername() === null) {

            $this->setUsername($user->getUsername());
        }

        if ($this->getPassword() === null) {

            $this->setPassword($user->getPassword());
        }

        if ($this->getState() === null) {

            $this->setState($user->getState());
        }

        $properties = $user->getProperties();
        foreach ($properties as $key => $property) {

            if (empty($this->getProperty($key))) {
                $this->setProperty($key, $property);
            }
        }
    }


}