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

class CreateUserFailListener extends AbstractListener {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\Service\RcmUserService';
    protected $event = 'createUser.fail';
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
        $failresult = $e->getParam('failResult');
        //$results = $e->getParam('results');

        return new Result($failresult->getUser());
    }
} 