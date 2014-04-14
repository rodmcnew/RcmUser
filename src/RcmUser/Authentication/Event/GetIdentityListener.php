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


class GetIdentityListener extends AbstractAuthServiceListener {

    protected $event = 'getIdentity';
    protected $priority = 100;

    /**
     * @param $e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        $user = $e->getParam('user');

        $authService = $this->getAuthService();

        $currentUser = $authService->getIdentity();

        if(!empty($currentUser)){

            $user->populate($currentUser);
        }

        return $user;
    }
} 