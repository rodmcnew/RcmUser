<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\User;


/**
 * Class Result
 *
 * @package RcmUser\Model\User
 */
class Result
{

    /**
     *
     */
    const CODE_SUCCESS = 1;
    /**
     *
     */
    const CODE_FAIL = 0;

    /**
     *
     */
    const DEFAULT_KEY = '_default';

    /**
     * @var int
     */
    protected $code = 1;

    /**
     * @var null
     */
    protected $user = null;

    /**
     * @var array
     */
    protected $messages = array();

    public function __construct($user = null, $code = 1, $messages = array())
    {
        $this->setUser($user);

        $this->setCode($code);

        if(!is_array($messages)){

            $messages = array(self::DEFAULT_KEY => (string) $messages);
        }

        $this->setMessages($messages);
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param array $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setMessage($key = null, $value = null)
    {
        if ($key === null) {
            $this->messages[self::DEFAULT_KEY] = $value;
        } else {
            $this->messages[$key] = $value;
        }
    }

    /**
     * @param      $key
     * @param null $deflt
     *
     * @return mixed
     */
    public function getMessage($key = self::DEFAULT_KEY, $deflt = null)
    {

        if (array_key_exists($this->messages, $key)) {

            return $this->messages[$key];
        }

        return $deflt;
    }

    /**
     * @param null $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {

        if ($this->getCode() >= self::CODE_SUCCESS) {

            return true;
        }

        return false;
    }
} 