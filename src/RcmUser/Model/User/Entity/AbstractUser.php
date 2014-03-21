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
 * Class AbstractUser
 *
 * @package RcmUser\Model\User\Entity
 */
abstract class AbstractUser implements UserInterface
{

    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = (string)$id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->registeredId;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = (string)$username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Populate from an array or object.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
        if(($data instanceof UserInterface)){

            $this->setId($data->getId());
            $this->setUsername($data->getUsername());
            $this->setPassword($data->getPassword());
        }

        if(is_array($data)){

            $this->setId($data['id']);
            $this->setUsername($data['username']);
            $this->setPassword($data['password']);
        }

        throw new \Exception('User data could not be populated, date format not supported');
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        // @todo do not expose whole object here
        return get_object_vars($this);
    }
} 