<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Properties\Entity;


class AbstractProperty implements PropertyInterface
{

    public function get($key, $def = null, $params = array())
    {
        $method = PropertyInterface::GETTER_PRE . ucfirst($key);

        if (method_exists($this, $method)){

            return $this->$method($params);
        }

        return $def;
    }

    public function set($key, $val = null, $params = array())
    {

        $method = PropertyInterface::SETTER_PRE . ucfirst($key);

        if (method_exists($this, $method)){

            return $this->$method($val, $params);
        }

        return false;
    }

} 