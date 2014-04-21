<?php
/**
 * UpdateUserPreDataPrepListener.php
 *
 * UpdateUserPreDataPrepListener
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
 * Class UpdateUserPreDataPrepListener
 *
 * UpdateUserPreDataPrepListener
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
class UpdateUserPreDataPrepListener extends AbstractUserDataPrepListener
{
    protected $event = 'updateUser.pre';
    protected $priority = 5;

    /**
     * onEvent
     *
     * @param \Event $e e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        // $target = $e->getTarget();
        $updatedUser = $e->getParam('updatedUser');
        $updatableUser = $e->getParam('updatableUser');

        return $this->getUserDataPreparer()->prepareUserUpdate(
            $updatedUser,
            $updatableUser
        );
    }
} 