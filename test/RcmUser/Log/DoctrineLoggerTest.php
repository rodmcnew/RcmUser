<?php
 /**
 * DoctrineLoggerTest.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Log
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test\Log;

require_once __DIR__ . '/../../Zf2TestCase.php';

use RcmUser\Log\DoctrineLogger;

/**
 * Class DoctrineLoggerTest
 *
 * DoctrineLoggerTest
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test\Log
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class DoctrineLoggerTest extends \PHPUnit_Framework_TestCase {

    /**
     * test
     *
     * @return void
     */
    public function test()
    {
        $em = $this->getMockBuilder(
            '\Doctrine\ORM\EntityManager'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $logger = new DoctrineLogger($em, \Zend\Log\Logger::ERR);

        $logResult = $logger->log('ERR', 'message');

        $this->assertInstanceOf('\Zend\Log\LoggerInterface', $logResult);

        $logResult = $logger->log('INFO', 'message');

        $this->assertInstanceOf('\Zend\Log\LoggerInterface', $logResult);

    }
}
 