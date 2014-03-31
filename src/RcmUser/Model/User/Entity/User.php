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


class User extends AbstractUser
{
    /**
     * Property data injected by external sources
     *
     * @var array
     */
    protected $properties = array();

    /**
     * @param array $properties
     */
    public function setProperties($properies)
    {
        $this->properies = $properies;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $property
     */
    public function setProperty($key, $val)
    {
        $this->properties[$key] = $val;
    }

    /**
     * @return array
     */
    public function getProperty($key, $dflt = null)
    {
        if (array_key_exists($key, $this->properties)) {

            return $this->properties[$key];
        }

        return $dflt;
    }

}