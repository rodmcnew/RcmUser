<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Properties\Entity;


interface PropertyInterface {

    const GETTER_PRE = 'get';
    const SETTER_PRE = 'set';

    public function get($key, $def = null);

    public function set($key, $val = null);
} 