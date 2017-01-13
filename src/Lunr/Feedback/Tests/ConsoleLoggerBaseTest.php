<?php

/**
 * This file contains the ConsoleLoggerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Psr\Log\LogLevel;

/**
 * This class contains test methods for the ConsoleLogger class.
 *
 * @covers Lunr\Feedback\ConsoleLogger
 */
class ConsoleLoggerBaseTest extends ConsoleLoggerTest
{

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the console class is set correctly.
     */
    public function testConsoleSetCorrectly()
    {
        $this->assertPropertySame('console', $this->console);
    }

    /**
     * Test that log() logs correctly to the console.
     *
     * @covers Lunr\Feedback\ConsoleLogger::log
     */
    public function testLogOutputsMessageOnCommandLine()
    {
        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('WARNING: Foo'));

        $this->class->log(LogLevel::WARNING, 'Foo');
    }

}

?>
