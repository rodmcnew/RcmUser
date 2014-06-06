<?php
/**
 * DoctrineLogger.php
 *
 * DoctrineLogger
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

use Doctrine\ORM\EntityManager;
use RcmUser\Log\Entity\DbLogEntry;
use RcmUser\Log\Entity\DoctrineLogEntry;
use RcmUser\Log\Entity\LogEntry;
use Zend\Log\LoggerInterface;


/**
 * Class DoctrineLogger
 *
 * DoctrineLogger
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
class DoctrineLogger implements LoggerInterface
{

    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {

        $this->entityManager = $entityManager;
    }


    public function log($type, $message, $extra = array())
    {
        $tz = new \DateTimeZone('UTC');
        $date = new \DateTime('now', $tz);
        $type = strtoupper($type);
        $extra = json_encode($extra);

        $logEntry = new DoctrineLogEntry($date, $type, $message, $extra);

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function emerg($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function alert($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function crit($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function err($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function warn($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function notice($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function info($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

    /**
     * @param string            $message
     * @param array|Traversable $extra
     *
     * @return LoggerInterface
     */
    public function debug($message, $extra = array())
    {
        $this->log(__FUNCTION__, $message, $extra);
    }

} 