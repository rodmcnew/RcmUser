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


use RcmUser\Event\AbstractListener;
use RcmUser\User\Result;

class CreateUserPreListener extends AbstractListener {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\User\Service\UserDataService';
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

        $target = $e->getTarget();
        $userToCreate = $e->getParam('userToCreate');
        $resultUser = $e->getParam('resultUser');

        // run validation rules
        $validateResult = $target->getUserValidatorService()->validateUser($userToCreate);

        if (!$validateResult->isSuccess()) {

            return $validateResult;
        }

        return new Result($resultUser);
    }
} 