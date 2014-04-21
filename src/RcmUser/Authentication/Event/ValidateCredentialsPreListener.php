<?php
/**
 * ValidateCredentialsPreListener.php
 *
 * ValidateCredentialsPreListener
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
 * ValidateCredentialsPreListener
 *
 * ValidateCredentialsPreListener
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
class ValidateCredentialsPreListener extends AbstractAuthServiceListener
{

    protected $event = 'validateCredentials.pre';
    protected $priority = 100;

    /**
     * onEvent
     *
     * @param EVENT $e E
     *
     * @return Result
     */
    public function onEvent($e)
    {

        $result = $e->getParam('result');
        $user = $e->getParam('user');

        // RcmUser Auth
        $adapter = $this->getAuthService()->getAdapter();
        $adapter->setUser($user);
        $result = $adapter->authenticate();

        return $result;
    }
} 