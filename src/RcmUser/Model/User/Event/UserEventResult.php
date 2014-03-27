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


use RcmUser\Model\User\Result;

/**
 * Class UserEventResult
 * This allows the events to check in the main user data has been prepared/validated
 * If the event listeners pay attention to this, they can avoid over-riding each other
 *
 * @package RcmUser\Model\User\Event
 */
class UserEventResult extends Result {

    /**
     * @var bool
     */
    protected $userObjectDataIsPrepared = false;

    /**
     * @param boolean $userObjectDataIsPrepared
     */
    public function setUserObjectDataIsPrepared($userObjectDataIsPrepared)
    {
        $this->userObjectDataIsPrepared = $userObjectDataIsPrepared;
    }

    /**
     * @return boolean
     */
    public function getUserObjectDataIsPrepared()
    {
        return $this->userObjectDataIsPrepared;
    }



} 