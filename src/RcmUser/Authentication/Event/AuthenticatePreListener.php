<?php
/**
 * AuthenticatePreListener.php
 *
 * AuthenticatePreListener
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
 * AuthenticatePreListener
 *
 * AuthenticatePreListener
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
class AuthenticatePreListener extends AbstractAuthServiceListener
{

    protected $event = 'authenticate.pre';
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

        //$result = $e->getParam('result');
        $user = $e->getParam('user');

        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $result = $this->getAuthService()->authenticate($adapter);

        return $result;
    }
} 