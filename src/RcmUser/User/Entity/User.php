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

use
    RcmUser\Exception\RcmUserException;

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
     * @var string $email
     */
    protected $email = null;

    /**
     * @var string $name Display name
     */
    protected $name = null;

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
        $username = (string)$username;

        if (empty($username)) {

            $username = null;
        }
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
        $password = (string)$password;
        if (empty($password)) {
            $password = null;
        }
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
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function setState($state)
    {
        $state = (string)$state;

        if (!$this->isValidState($state)) {

            throw new RcmUserException("User state is invalid: {$state}");
        }

        if (empty($state)) {
            $state = null;
        }
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
     * setEmail
     *
     * @param string $email valid email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $email = (string)$email;
        if (empty($email)) {

            $email = null;
        }
        $this->email = $email;
    }

    /**
     * getEmail
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * setName
     *
     * @param string $name Display name
     *
     * @return void
     */
    public function setName($name)
    {
        $name = (string)$name;
        if (empty($name)) {

            $name = null;
        }
        $this->name = $name;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
        if (empty($properties)) {

            $properties = array();
        }
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
     * @param string $propertyId propertyId
     * @param mixed  $value      value
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function setProperty(
        $propertyId,
        $value
    ) {
        if (!$this->isValidPropertyId($propertyId)) {

            throw new RcmUserException("Property Id is invalid: {$propertyId}");
        }

        $this->properties[$propertyId] = $value;
    }

    /**
     * getProperty
     *
     * @param string $propertyId propertyId
     * @param null   $default    default if not found
     *
     * @return null
     */
    public function getProperty(
        $propertyId,
        $default = null
    ) {
        if (array_key_exists(
            $propertyId,
            $this->properties
        )
        ) {
            return $this->properties[$propertyId];
        }

        return $default;
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
     * isValidPropertyId
     *
     * @param string $propertyId propertyId
     *
     * @return bool
     */
    public function isValidPropertyId($propertyId)
    {
        if (preg_match(
            '/[^a-z_\-0-9]/i',
            $propertyId
        )
        ) {
            return false;
        }

        return true;
    }

    /**
     * isValidState
     *
     * @param string $state user stateå
     *
     * @return bool
     */
    public function isValidState($state)
    {
        if (preg_match(
            '/[^a-z_\-0-9]/i',
            $state
        )
        ) {
            return false;
        }

        return true;
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
    public function populate(
        $data,
        $exclude = array()
    ) {
        if (($data instanceof UserInterface)) {

            if (!in_array(
                'id',
                $exclude
            )
            ) {
                $this->setId($data->getId());
            }
            if (!in_array(
                'username',
                $exclude
            )
            ) {
                $this->setUsername($data->getUsername());
            }
            if (!in_array(
                'password',
                $exclude
            )
            ) {
                $this->setPassword($data->getPassword());
            }
            if (!in_array(
                'state',
                $exclude
            )
            ) {
                $this->setState($data->getState());
            }
            if (!in_array(
                'email',
                $exclude
            )
            ) {
                $this->setEmail($data->getEmail());
            }
            if (!in_array(
                'name',
                $exclude
            )
            ) {
                $this->setName($data->getName());
            }
            if (!in_array(
                'properties',
                $exclude
            )
            ) {
                $this->setProperties($data->getProperties());
            }

            return;
        }

        if (is_array($data)) {

            if (isset($data['id'])
                && !in_array(
                    'id',
                    $exclude
                )
            ) {
                $this->setId($data['id']);
            }
            if (isset($data['username'])
                && !in_array(
                    'username',
                    $exclude
                )
            ) {
                $this->setUsername($data['username']);
            }
            if (isset($data['password'])
                && !in_array(
                    'password',
                    $exclude
                )
            ) {
                $this->setPassword($data['password']);
            }
            if (isset($data['state'])
                && !in_array(
                    'state',
                    $exclude
                )
            ) {
                $this->setState($data['state']);
            }
            if (isset($data['email'])
                && !in_array(
                    'email',
                    $exclude
                )
            ) {
                $this->setEmail($data['email']);
            }
            if (isset($data['name'])
                && !in_array(
                    'name',
                    $exclude
                )
            ) {
                $this->setName($data['name']);
            }
            if (isset($data['properties'])
                && !in_array(
                    'properties',
                    $exclude
                )
            ) {
                // @todo we need to try to populate the correct objects here?
                $this->setProperties($data['properties']);
            }

            return;
        }

        throw new RcmUserException('User data could not be populated, data format not supported');
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
        $obj->email = $this->getEmail();
        $obj->name = $this->getName();
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

        if ($this->getEmail() === null) {

            $this->setEmail($user->getEmail());
        }

        if ($this->getName() === null) {

            $this->setName($user->getName());
        }

        $properties = $user->getProperties();
        foreach ($properties as $key => $property) {

            $userProperty = $this->getProperty($key);
            if (empty($userProperty)) {
                $this->setProperty(
                    $key,
                    $property
                );
            }
        }
    }
}
