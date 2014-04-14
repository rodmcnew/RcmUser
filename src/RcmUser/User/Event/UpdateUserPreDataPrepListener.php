<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Event;


use RcmUser\User\Result;

class UpdateUserPreDataPrepListener extends AbstractUserDataPrepListener
{
    protected $event = 'updateUser.pre';
    protected $priority = 5;

    /**
     * @param $e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        // $target = $e->getTarget();
        $updatedUser = $e->getParam('updatedUser');
        $updatableUser = $e->getParam('updatableUser');

        return $this->getUserDataPrepService()->prepareUserUpdate($updatedUser, $updatableUser);
    }
} 