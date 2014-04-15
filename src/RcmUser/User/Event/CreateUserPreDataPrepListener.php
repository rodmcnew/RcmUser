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

class CreateUserPreDataPrepListener extends AbstractUserDataPrepListener
{
    protected $event = 'createUser.pre';
    protected $priority = 5;

    /**
     * @param $e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        //$target = $e->getTarget();
        $newUser = $e->getParam('newUser');
        $creatableUser = $e->getParam('creatableUser');

        return $this->getUserDataPreparer()->prepareUserCreate($newUser, $creatableUser);
    }
} 