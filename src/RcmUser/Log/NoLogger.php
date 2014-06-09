<?php
/**
 * NoLogger.php
 *
 * NoLogger
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
 * Class NoLogger
 *
 * NoLogger
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
class NoLogger implements LoggerInterface
{
    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function emerg($message, $extra = array())
    {
        // No Logging
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function alert($message, $extra = array())
    {
// No Logging
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function crit($message, $extra = array())
    {
        // No Logging
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function err($message, $extra = array())
    {
        // No Logging
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function warn($message, $extra = array())
    {
        // No Logging
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function notice($message, $extra = array())
    {
        // No Logging
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function info($message, $extra = array())
    {
        // No Logging
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function debug($message, $extra = array())
    {
        // No Logging
    }

} 