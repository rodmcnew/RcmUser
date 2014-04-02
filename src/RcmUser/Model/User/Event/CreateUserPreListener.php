<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\User\Event;


use RcmUser\Model\Event\AbstractListener;
use RcmUser\Model\User\Result;

class CreateUserPreListener extends AbstractListener {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\Service\RcmUserDataService';
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

        // run validation rules
        $validateResult = $target->getUserValidatorService()->validateUser($userToCreate);

        if (!$validateResult->isSuccess()) {

            return $validateResult;
        }

        $userToCreate->setId($target->buildId());
        $userToCreate->setPassword($target->getEncryptor()->create($userToCreate->getPassword()));

        return new Result($userToCreate);
    }
} 