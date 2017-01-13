<?php

/**
 * This file contains the AbstractLoggerDatetimeTest class.
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
 * This class contains test methods for the AbstractLogger class.
 *
 * @covers Lunr\Feedback\AbstractLogger
 */
class AbstractLoggerDateTimeTest extends AbstractLoggerTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpDateTime();
    }

    /**
     * Test that compose_timestamped_message() without request and file/line metadata present returns the interpolated message.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      Lunr\Feedback\Tests\AbstractLoggerNoDateTimeTest::testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\AbstractLogger::compose_timestamped_message
     */
    public function testComposeMessageWithoutRequestAndFileInfoReturnsInterpolatedMessage($message, $context, $expected)
    {
        $method = $this->get_accessible_reflection_method('compose_timestamped_message');

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals(self::DATETIME_LOG_STRING . $expected, $msg);
    }

    /**
     * Test message composition when call is not set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      Lunr\Feedback\Tests\AbstractLoggerNoDateTimeTest::testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\AbstractLogger::compose_timestamped_message
     */
    public function testComposeMessageWithCallUnAvailable($message, $context, $expected)
    {
        $method = $this->get_accessible_reflection_method('compose_timestamped_message');

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue(NULL));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals(self::DATETIME_LOG_STRING . $expected, $msg);
    }

    /**
     * Test message composition when call is set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      Lunr\Feedback\Tests\AbstractLoggerNoDateTimeTest::testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\AbstractLogger::compose_timestamped_message
     */
    public function testComposeMessageWithCallAvailable($message, $context, $expected)
    {
        $method = $this->get_accessible_reflection_method('compose_timestamped_message');

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals(self::DATETIME_LOG_STRING . 'controller/method: ' . $expected, $msg);
    }

    /**
     * Test message composition when only file is set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      Lunr\Feedback\Tests\AbstractLoggerNoDateTimeTest::testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\AbstractLogger::compose_timestamped_message
     */
    public function testComposeMessageWithFileAvailable($message, $context, $expected)
    {
        $context['file'] = 'Test.php';

        $method = $this->get_accessible_reflection_method('compose_timestamped_message');

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals(self::DATETIME_LOG_STRING . $expected, $msg);
    }

    /**
     * Test message composition when only line is set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      Lunr\Feedback\Tests\AbstractLoggerNoDateTimeTest::testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\AbstractLogger::compose_timestamped_message
     */
    public function testComposeMessageWithLineAvailable($message, $context, $expected)
    {
        $context['line'] = '223';

        $method = $this->get_accessible_reflection_method('compose_timestamped_message');

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals(self::DATETIME_LOG_STRING . $expected, $msg);
    }

    /**
     * Test message composition when file and line are set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      Lunr\Feedback\Tests\AbstractLoggerNoDateTimeTest::testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\AbstractLogger::compose_timestamped_message
     */
    public function testComposeMessageWithFileAndLineAvailable($message, $context, $expected)
    {
        $context['file'] = 'Test.php';
        $context['line'] = '223';

        $method = $this->get_accessible_reflection_method('compose_timestamped_message');

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals(self::DATETIME_LOG_STRING . $expected . ' (Test.php: 223)', $msg);
    }

}

?>
