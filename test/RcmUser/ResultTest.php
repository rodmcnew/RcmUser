<?php
/**
 * ResultTest.php
 *
 * TEST
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Test
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Test;

use RcmUser\Result;
use RcmUser\Zf2TestCase;

require_once __DIR__ . '/../Zf2TestCase.php';

class ResultTest extends Zf2TestCase
{
    /**
     * testSetGet
     *
     * @covers \RcmUser\Result
     *
     * @return void
     */
    public function testSetGet()
    {
        $result = new Result(null, Result::CODE_SUCCESS, 'DEFAULT_MESSAGE');
        $data = 'SOMEDATA';

        $result->setCode(Result::CODE_SUCCESS);
        $result->setData($data);
        $messages = array('message 1');
        $result->setMessages($messages);
        $result->setMessage('message 2');

        $this->assertTrue($result->getCode() === Result::CODE_SUCCESS, 'Data not returned.');
        $this->assertTrue($result->getData() === $data, 'Data not returned.');

        $returnedMessages = $result->getMessages();
        $this->assertTrue(is_array($returnedMessages), 'Messages should be array.');

        $this->assertTrue($returnedMessages[0] === $messages[0], 'Message 1 not returned.');

        $this->assertTrue($result->getMessage(1) === 'message 2', 'Message 2 not returned.');

        $this->assertTrue($result->getMessage('nope', 'not_found') === 'not_found', 'Message unset default not returned.');
    }

    /**
     * testIsSuccess
     *
     * @covers \RcmUser\Result::isSuccess
     *
     * @return void
     */
    public function testIsSuccess()
    {
        $result = new Result();
        $data = 'SOMEDATA';

        $result->setCode(Result::CODE_SUCCESS);

        $this->assertTrue($result->isSuccess(), 'Success not returned.');

        $result->setCode(Result::CODE_FAIL);

        $this->assertFalse($result->isSuccess(), 'Success returned.');
    }
}
 