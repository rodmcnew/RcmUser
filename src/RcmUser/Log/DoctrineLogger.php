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
class DoctrineLogger extends Logger
{

    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager, $logLevel = Logger::LEVEL_ERR)
    {
        $this->entityManager = $entityManager;
        $this->setLogLevel($logLevel);
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
    public function log($type, $message, $extra = array())
    {
        if(!$this->canLog($type)){

            return $this;
        }
        $tz = new \DateTimeZone('UTC');
        $dateTimeUtc = new \DateTime('now', $tz);
        $type = strtoupper($type);
        $extra = json_encode($extra);

        $logEntry = new DoctrineLogEntry($dateTimeUtc, $type, $message, $extra);

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();

        return $this;
    }


} 