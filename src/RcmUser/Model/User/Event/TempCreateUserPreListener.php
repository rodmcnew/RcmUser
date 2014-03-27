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

class TempCreateUserPreListener extends AbstractListener {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\Service\RcmUserService';
    protected $event = 'createUser.pre';
    protected $priority = 2;

    /**
     * @param $e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        echo $this->priority . ": ". get_class($this) . "\n";

        $target = $e->getTarget();
        $newuser = $e->getParam('newUser');

        var_dump('TEMP:',$newuser);

        return new Result($newuser);
    }
} 