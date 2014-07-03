<?php
/**
 * Result.php
 *
 * Result
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser;

use RcmUser\Exception\RcmUserResultException;


/**
 * Class Result
 *
 * Result
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Result implements \JsonSerializable
{

    /**
     * @var int CODE_SUCCESS
     */
    const CODE_SUCCESS = 1;
    /**
     * @var int CODE_FAIL
     */
    const CODE_FAIL = 0;
    /**
     * @var int DEFAULT_KEY
     */
    const DEFAULT_KEY = 0;

    /**
     * @var string $messageDelimiter
     */
    protected $messageDelimiter = ' | ';

    /**
     * @var int
     */
    protected $code = 1;

    /**
     * @var null
     */
    protected $data = null;

    /**
     * @var array
     */
    protected $messages = array();

    /**
     * __construct
     *
     * @param mixed $data     data
     * @param int   $code     code
     * @param array $messages messages
     */
    public function __construct($data = null, $code = 1, $messages = array())
    {
        $this->setData($data);

        $this->setCode($code);

        if (!is_array($messages)) {

            $message = (string)$messages;
            if (!empty($message)) {

                $this->setMessage($message);
            }
        } else {

            $this->setMessages($messages);
        }
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
     * getMessagesString
     *
     * @return array
     */
    public function getMessagesString()
    {
        return implode($this->messageDelimiter, $this->messages);
    }

    /**
     * setMessage
     *
     * @param string $value value
     *
     * @return void
     */
    public function setMessage($value = null)
    {
        $this->messages[] = $value;
    }

    /**
     * getMessage
     *
     * @param int   $key     key
     * @param mixed $default default
     *
     * @return null|mixed
     */
    public function getMessage($key = self::DEFAULT_KEY, $default = null)
    {
        if (isset($this->messages[$key])) {

            return $this->messages[$key];
        }

        return $default;
    }

    /**
     * setData - valid data format
     *
     * @param mixed $data data
     *
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * getData - should always return valid data format, even is not success
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * isSuccess
     *
     * @return bool
     */
    public function isSuccess()
    {
        if ($this->getCode() >= self::CODE_SUCCESS) {

            return true;
        }

        return false;
    }

    /**
     * throwFailure - throw exception if not isSuccess
     *
     * @return void
     * @throws Exception\RcmUserResultException
     */
    public function throwFailure()
    {
        if (!$this->isSuccess()) {

            throw new RcmUserResultException($this->getMessagesString());
        }
    }

    /**
     * jsonSerialize
     *
     * @return \stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->code = $this->getCode();
        $obj->messages = $this->getMessages();
        $obj->data = $this->getData();

        return $obj;
    }
} 