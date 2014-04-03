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


class User extends AbstractUser implements \JsonSerializable
{
    /**
     * Property data injected by external sources
     *
     * @var array
     */
    protected $properties = array();

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
     * @param null $dflt
     *
     * @return null
     */
    public function getProperty($key, $dflt = null)
    {
        if (array_key_exists($key, $this->properties)) {

            return $this->properties[$key];
        }

        return $dflt;
    }

    /**
     * @param array $data
     *
     * @throws RcmUserException
     */
    public function populate($data = array())
    {
        if (($data instanceof User)) {

            $this->setProperties($data->getProperties());

            return parent::populate($data);
        }

        if (is_array($data)) {

            if (isset($data['properties'])) {
                $this->setProperties($data['properties']);
            }

            return parent::populate($data);
        }

        throw new RcmUserException('User data could not be populated, date format not supported');
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