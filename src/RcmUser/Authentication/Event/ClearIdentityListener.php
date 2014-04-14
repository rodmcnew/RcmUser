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


class ClearIdentityListener extends AbstractAuthServiceListener {

    protected $event = 'clearIdentity';
    protected $priority = 100;

    /**
     * @param $e
     *
     * @return Result
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