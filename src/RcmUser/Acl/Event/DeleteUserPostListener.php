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


use RcmUseRcmUserResult;

class DeleteUserPostListener extends AbstractUserDataServiceListener
{

    protected $event = 'deleteUser.post';
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

            $aclResult = $this->getUserRolesDataMapper()->delete($user);

            if (!$aclResult->isSuccess()) {

                return $aclResult;
                //throw new \Exception($this->getUserPropertyKey() . ': ACL Roles could not be deleted for user. ' . json_encode($aclResult->getMessages()));
            }

            $user->setProperty($this->getUserPropertyKey(), $this->getDefaultRoleIdentities());

            return new Result($user, Result::CODE_SUCCESS);
        }

        return $result;
    }
} 