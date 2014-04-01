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

class CreateUserSuccessListener extends AbstractUserDataServiceListener {

    protected $event = 'createUser.success';
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

        $user->setProperty('RcmUser\Model\Acl\UserRoles', $this->getDefaultAuthenticatedRoleIdentities());

        $result = $this->getUserRolesDataMapper()->create($user, $user->getProperty('RcmUser\Model\Acl\UserRoles', array()));

        // @todo throw error is fail or short circuit - currently, event trigger doe not care about this event

        return $result;
    }
} 