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

class UpdateUserPreValidatorListener extends AbstractUserValidatorListener
{

    protected $event = 'updateUser.pre';
    protected $priority = 100;

    /**
     * @param $e
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
        return $this->getUserValidatorService()->validateUpdateUser($updatedUser, $updatableUser);
    }
} 