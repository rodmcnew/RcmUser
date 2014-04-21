<?php
/**
 * UpdateUserPreValidatorListener.php
 *
 * UpdateUserPreValidatorListener
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
 * Class UpdateUserPreValidatorListener
 *
 * UpdateUserPreValidatorListener
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
class UpdateUserPreValidatorListener extends AbstractUserValidatorListener
{

    protected $event = 'updateUser.pre';
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
        //echo $this->priority . ": ". get_class($this) . "\n";

        //$target = $e->getTarget();
        $updatedUser = $e->getParam('updatedUser');
        $updatableUser = $e->getParam('updatableUser');

        // run validation rules
        return $this->getUserValidator()->validateUpdateUser(
            $updatedUser,
            $updatableUser
        );
    }
} 