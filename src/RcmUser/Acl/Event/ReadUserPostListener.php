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


use RcmUser\Result;

class ReadUserPostListener extends AbstractUserDataServiceListener
{

    protected $event = 'readUser.post';
    protected $priority = 100;

    /**
     * @param $e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        $result = $e->getParam('result');
        if ($result->isSuccess()) {

            $user = $result->getUser();

            $readResult = $this->getUserRolesDataMapper()->read($user);

            if ($readResult->isSuccess()) {

                $roles = $readResult->getData();
            } else {

                $roles = $this->getDefaultAuthenticatedRoleIdentities();
            }

            $user->setProperty($this->getUserPropertyKey(), $roles);

            return new Result($user, Result::CODE_SUCCESS);
        }

        return $result;
    }
} 