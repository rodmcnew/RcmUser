<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Acl\Event;


use RcmUser\Model\User\Result;

class ReadUserSuccessListener extends AbstractUserDataServiceListener {

    protected $event = 'readUser.success';
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
        $result = $e->getParam('result');
        $user = $result->getUser();

        $roles = $this->getUserRolesDataMapper()->read($user);

        $user->setProperty('RcmUser\Model\Acl\UserRoles', $roles);

        return new Result($user, 1);
    }
} 