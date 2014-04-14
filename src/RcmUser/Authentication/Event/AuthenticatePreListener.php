<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Authentication\Event;


class AuthenticatePreListener extends AbstractAuthServiceListener {

    protected $event = 'authenticate.pre';
    protected $priority = 100;

    /**
     * @param $e
     *
     * @return Result
     */
    public function onEvent($e)
    {

        //$result = $e->getParam('result');
        $user = $e->getParam('user');
        
        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $result =  $this->getAuthService()->authenticate($adapter);

        return $result;
    }
} 