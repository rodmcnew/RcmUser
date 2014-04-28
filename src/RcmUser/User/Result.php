<?php
/**
 * Result.php
 *
 * Result
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User;

use RcmUser\User\Entity\User;


/**
 * Class Result
 *
 * Result
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Result
{

    /**
     * int
     */
    const CODE_SUCCESS = 1;
    /**
     * int
     */
    const CODE_FAIL = 0;

    /**
     * string
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

    /**
     * __construct
     *
     * @param User  $user     user
     * @param int   $code     code
     * @param array $messages messages
     */
    public function __construct($user = null, $code = 1, $messages = array())
    {
        $this->setUser($user);

        $this->setCode($code);

        if (!is_array($messages)) {

            $messages = array(self::DEFAULT_KEY => (string)$messages);
        }

        $this->setMessages($messages);
    }

    /**
     * setCode
     *
     * @param int $code code
     *
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * getCode
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * setMessages
     *
     * @param array $messages messages
     *
     * @return void
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * getMessages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * setMessage
     *
     * @param string $key   key
     * @param mixed  $value value
     *
     * @return void
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
     * getMessage
     *
     * @param string $key   key
     * @param mixed  $deflt deflt
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
     * setUser
     *
     * @param User|null $user user
     *
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * getUser
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * isSuccess
     *
     * @return bool
     */
    public function isSuccess()
    {

        if ($this->getCode() >= self::CODE_SUCCESS && ($this->user instanceof User)) {

            return true;
        }

        return false;
    }
} 