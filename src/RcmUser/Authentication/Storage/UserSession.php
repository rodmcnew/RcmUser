<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Authentication\Storage;


use Zend\Authentication\Storage\Session;

class UserSession extends Session{

    public function __construct($namespace = 'RcmUser', $member = 'user', SessionManager $manager = null)
    {
        parent::__construct($namespace, $member, $manager);
    }
}