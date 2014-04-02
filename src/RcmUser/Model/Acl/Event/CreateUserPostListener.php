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

class CreateUserPostListener extends AbstractUserDataServiceListener
{

    protected $event = 'createUser.post';
    protected $priority = 100;

    /**
     * @param $e
     *
     * @return Result|void
     * @throws \Exception
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        $result = $e->getParam('result');

        if ($result->isSuccess()) {

            $user = $result->getUser();

            $currentRoles = $user->getProperty('RcmUser\Model\Acl\UserRoles', null);

            if ($currentRoles === null) {

                $user->setProperty('RcmUser\Model\Acl\UserRoles', $this->getDefaultAuthenticatedRoleIdentities());
            }

            $aclResult = $this->getUserRolesDataMapper()->create($user, $user->getProperty('RcmUser\Model\Acl\UserRoles', array()));

            if (!$aclResult->isSuccess()) {

                throw new \Exception('RcmUser\Model\Acl\UserRoles' . ': ACL Roles could not be created for user. ' . json_encode($aclResult->getMessages()));
            }

            $user->setProperty('RcmUser\Model\Acl\UserRoles', $aclResult->getData());

            return new Result($user, Result::CODE_SUCCESS);
        }

        return $result;
    }
} 