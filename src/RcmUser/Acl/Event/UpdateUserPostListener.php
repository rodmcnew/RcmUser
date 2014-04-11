<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Event;


use RcmUser\User\Result;

class UpdateUserPostListener extends AbstractUserDataServiceListener
{

    protected $event = 'updateUser.post';
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

        //$target = $e->getTarget();
        $result = $e->getParam('result');

        if ($result->isSuccess()) {

            $user = $result->getUser();

            $currentRoles = $user->getProperty($this->getUserPropertyKey(), null);

            if ($currentRoles === null) {

                $user->setProperty($this->getUserPropertyKey(), $this->getDefaultAuthenticatedRoleIdentities());
            }

            $aclResult = $this->getUserRolesDataMapper()->update($user, $user->getProperty($this->getUserPropertyKey(), array()));

            if (!$aclResult->isSuccess()) {

                throw new \Exception($this->getUserPropertyKey(). ': ACL Roles could not be updated for user. ' . json_encode($aclResult->getMessages()));
            }

            $user->setProperty($this->getUserPropertyKey(), $aclResult->getData());

            return new Result($user, Result::CODE_SUCCESS);
        }

        return $result;
    }
} 