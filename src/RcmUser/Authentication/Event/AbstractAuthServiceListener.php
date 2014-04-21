<?php
/**
 * AbstractAuthServiceListener.php
 *
 * AbstractAuthServiceListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Authentication\Event;


use RcmUser\Event\AbstractListener;

/**
 * AbstractAuthServiceListener
 *
 * AbstractAuthServiceListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Authentication\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractAuthServiceListener extends AbstractListener
{

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    /**
     * @var string
     */
    protected $id = 'RcmUser\Authentication\Service\UserAuthenticationService';
    /**
     * @var string
     */
    protected $event = 'authentication';
    /**
     * @var int
     */
    protected $priority = 100;

    /**
     * @var
     */
    protected $authService;

    /**
     * setAuthService
     *
     * @param \Zend\Authentication\AuthenticationService $authService authService
     *
     * @return void
     */
    public function setAuthService(
        \Zend\Authentication\AuthenticationService $authService
    ) {
        $this->authService = $authService;
    }

    /**
     * getAuthService
     *
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }
} 