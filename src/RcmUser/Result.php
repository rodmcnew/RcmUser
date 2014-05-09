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
    protected $data = null;

    /**
     * @var array
     */
    protected $messages = array();

    /**
     * __construct
     *
     * @param null  $data     data
     * @param int   $code     code
     * @param array $messages messages
     */
    public function __construct($data = null, $code = 1, $messages = array())
    {
        $this->setData($data);

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

        if (array_key_exists($key, $this->messages)) {

            return $this->messages[$key];
        }

        return $deflt;
    }

    /**
     * setData
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
     * getData
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