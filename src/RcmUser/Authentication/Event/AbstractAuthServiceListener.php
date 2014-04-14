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


use RcmUser\Event\AbstractListener;

class AbstractAuthServiceListener extends AbstractListener {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\Authentication\Service\UserAuthenticationService';
    protected $event = 'authentication';
    protected $priority = 100;

    /**
     * @var
     */
    protected $authService;

    /**
     * @param mixed $authService
     */
    public function setAuthService(\Zend\Authentication\AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return mixed
     */
    public function getAuthService()
    {
        return $this->authService;
    }
} 