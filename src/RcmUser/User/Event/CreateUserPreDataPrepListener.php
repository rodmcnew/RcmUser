<?php
/**
 * CreateUserPreDataPrepListener.php
 *
 * CreateUserPreDataPrepListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Event;


use RcmUser\User\Result;

/**
 * Class CreateUserPreDataPrepListener
 *
 * CreateUserPreDataPrepListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CreateUserPreDataPrepListener extends AbstractUserDataPrepListener
{
    protected $event = 'createUser.pre';
    protected $priority = 5;

    /**
     * onEvent
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        //$target = $e->getTarget();
        $newUser = $e->getParam('newUser');
        $creatableUser = $e->getParam('creatableUser');

        return $this->getUserDataPreparer()->prepareUserCreate(
            $newUser,
            $creatableUser
        );
    }
} 