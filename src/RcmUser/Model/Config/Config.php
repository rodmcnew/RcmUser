<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Config;


class Config {

    protected $data = array();

    public function __construct($data = array()){

        $this->data = $data;
    }

    public function get($key, $def = null){

        if(isset($this->data[$key])){

            return $this->data[$key];
        }

        return $def;
    }
} 