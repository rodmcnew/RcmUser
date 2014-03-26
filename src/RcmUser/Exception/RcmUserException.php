<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Exception;


class RcmUserException extends \Exception {

    /**
     * @var array
     */
    protected $messages = array();

    /**
     * @param array $messages
     */
    public function setMessages($inputMessages)
    {
        $this->messages = $inputMessages;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
} 