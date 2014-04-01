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


use RcmUser\Model\Acl\Entity\Role;
use RcmUser\Model\User\Result;

class CreateUserPreListener extends AbstractUserDataServiceListener {

    protected $event = 'createUser.pre';
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
        $newUser = $e->getParam('newUser');

        $property = $newUser->getProperty('RcmUser\Model\Acl\UserRoles', null);

        if($property === null){

            $newUser->setProperty('RcmUser\Model\Acl\UserRoles', $this->getDefaultRoleIdentities());
        }

        return new Result($newUser, Result::CODE_SUCCESS);
    }
} 