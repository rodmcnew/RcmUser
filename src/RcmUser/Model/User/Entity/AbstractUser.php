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

use RcmUser\Exception\RcmUserException;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/**
 * Class AbstractUser
 *
 * @package RcmUser\Model\User\Entity
 */
abstract class AbstractUser implements UserInterface, \JsonSerializable
{
    const PASSWORD_OBFUSCATE = null;

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
     * @param array $data
     *
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function populate($data = array())
    {
        if (($data instanceof UserInterface)) {

            $this->setId($data->getId());
            $this->setUsername($data->getUsername());
            $this->setPassword($data->getPassword());

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

            return;
        }

        throw new RcmUserException('User data could not be populated, data format not supported');
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

        return $obj;
    }

    public function getIterator()
    {

        return new \ArrayIterator(get_object_vars($this));
    }
} 