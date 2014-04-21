<?php
/**
 * ClearIdentityListener.php
 *
 * ClearIdentityListener
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

/**
 * ClearIdentityListener
 *
 * ClearIdentityListener
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
class ClearIdentityListener extends AbstractAuthServiceListener
{

    protected $event = 'clearIdentity';
    protected $priority = 100;

    /**
     * onEvent
     *
     * @param Event $e e
     *
     * @return bool
     */
    public function onEvent($e)
    {

        $authService = $this->getAuthService();
        //$currentUser = $authService->getIdentity();

        if ($authService->hasIdentity()) {

            $authService->clearIdentity();
        }

        return true;
    }
} 