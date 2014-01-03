<?php

/**
 * This file contains the ChainLoggerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Psr\Log\LogLevel;

/**
 * This class contains test methods for the ChainLogger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Feedback\ChainLogger
 */
class ChainLoggerBaseTest extends ChainLoggerTest
{

    /**
     * Test that the loggers passed to the constructor are stored correctly.
     */
    public function testLoggersSetCorrectly()
    {
        $loggers = $this->get_reflection_property_value('loggers');

        $this->assertInternalType('array', $loggers);
        $this->assertCount(2, $loggers);
        $this->assertContains($this->logger1, $loggers);
        $this->assertContains($this->logger2, $loggers);
    }

    /**
     * Test that log() forwards log calls to the stored loggers.
     *
     * @covers Lunr\Feedback\ChainLogger::log
     */
    public function testLogForwardsToSetLoggers()
    {
        $this->logger1->expects($this->once())
                      ->method('log')
                      ->with($this->equalTo(LogLevel::WARNING), $this->equalTo('message'), $this->equalTo([ 'key' => 'value' ]));

        $this->logger2->expects($this->once())
                      ->method('log')
                      ->with($this->equalTo(LogLevel::WARNING), $this->equalTo('message'), $this->equalTo([ 'key' => 'value' ]));

        $this->class->log(LogLevel::WARNING, 'message', [ 'key' => 'value' ]);
    }

}

?>
