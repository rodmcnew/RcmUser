<?php
/**
 * Logger.php
 *
 * Logger
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Log
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Log;

use Zend\Log\LoggerInterface;


/**
 * Class Logger
 *
 * Logger
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Log
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Logger implements LoggerInterface
{
    const LEVEL_EMERG = 80;
    const LEVEL_ALERT = 70;
    const LEVEL_CRIT = 60;
    const LEVEL_ERR = 50;
    const LEVEL_WARN = 40;
    const LEVEL_NOTICE = 30;
    const LEVEL_INFO = 20;
    const LEVEL_DEBUG = 10;

    protected $logLevel = Logger::LEVEL_ERR;

    /**
     * __construct
     *
     * @param int $logLevel logLevel
     */
    public function __construct($logLevel = Logger::LEVEL_ERR)
    {
        $this->setLogLevel($logLevel);
    }

    /**
     * setLogLevel
     *
     * @param int $logLevel logLevel
     *
     * @return void
     */
    protected function setLogLevel($logLevel)
    {
        $this->logLevel = $logLevel;
    }

    /**
     * getLogLevel
     *
     * @return int
     */
    public function getLogLevel()
    {
        return $this->logLevel;
    }

    /**
     * getLevel - get the level int from string
     *
     * @param string $type type
     *
     * @return mixed
     */
    public function getLevel($type)
    {
        if (defined('self::LEVEL_' . $type)) {

            return constant('self::LEVEL_' . $type);
        }

        return $this->logLevel;
    }

    /**
     * canLog
     *
     * @param int $type type
     *
     * @return bool
     */
    public function canLog($type)
    {
        $level = $this->getLevel($type);

        if ($level < $this->getLogLevel()) {
            // no logging
            return false;
        }

        return true;
    }

    /**
     * log
     *
     * @param string $type    type
     * @param string $message message
     * @param array  $extra   extra
     *
     * @return LoggerInterface
     */
    protected function log($type, $message, $extra = array())
    {
        if ($this->canLog($type)) {
            // no logging
            return $this;
        }

        return $this;
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function emerg($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function alert($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function crit($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function err($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function warn($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function notice($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function info($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function debug($message, $extra = array())
    {
        return $this->log(__FUNCTION__, $message, $extra);
    }
} 