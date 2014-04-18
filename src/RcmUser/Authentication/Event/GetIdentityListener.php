<?php
/**
 * GetIdentityListener.php
 *
 * GetIdentityListener
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
 * GetIdentityListener
 *
 * GetIdentityListener
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
class GetIdentityListener extends AbstractAuthServiceListener
{

    protected $event = 'getIdentity';
    protected $priority = 100;

    /**
     * onEvent
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        $user = $e->getParam('user');

        $authService = $this->getAuthService();

        $currentUser = $authService->getIdentity();

        if (!empty($currentUser)) {

            $user->populate($currentUser);
        }

        return $user;
    }
} 