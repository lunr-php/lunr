<?php

/**
 * This file contains the PHPLoggerTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Lunr\Feedback\PHPLogger;
use Psr\Log\LogLevel;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the PHPLogger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Feedback\PHPLogger
 */
class PHPLoggerTest extends LunrBaseTest
{

    /**
     * Mock-instance of the Request class.
     * @var Request
     */
    private $request;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $this->class      = new PHPLogger($this->request);
        $this->reflection = new ReflectionClass('Lunr\Feedback\PHPLogger');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->request);
        unset($this->class);
    }

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that interpolate_message replaces the placeholders as defined in $context.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\PHPLogger::interpolate_message
     */
    public function testInterpolateMessageReplacesPlaceholders($message, $context, $expected)
    {
        $method = $this->get_accessible_reflection_method('interpolate_message');

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals($expected, $msg);
    }

    /**
     * Test that compose_message() without request and file/line metadata present returns the interpolated message.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\PHPLogger::compose_message
     */
    public function testComposeMessageWithoutRequestAndFileInfoReturnsInterpolatedMessage($message, $context, $expected)
    {
        $method = $this->get_accessible_reflection_method('compose_message');

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals($expected, $msg);
    }

    /**
     * Test message composition when call is not set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\PHPLogger::compose_message
     */
    public function testComposeMessageWithCallUnAvailable($message, $context, $expected)
    {
        $method = $this->get_accessible_reflection_method('compose_message');

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue(NULL));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals($expected, $msg);
    }

    /**
     * Test message composition when call is set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\PHPLogger::compose_message
     */
    public function testComposeMessageWithCallAvailable($message, $context, $expected)
    {
        $method = $this->get_accessible_reflection_method('compose_message');

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals('controller/method: ' . $expected, $msg);
    }

    /**
     * Test message composition when only file is set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\PHPLogger::compose_message
     */
    public function testComposeMessageWithFileAvailable($message, $context, $expected)
    {
        $context['file'] = 'Test.php';

        $method = $this->get_accessible_reflection_method('compose_message');

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals($expected, $msg);
    }

    /**
     * Test message composition when only line is set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\PHPLogger::compose_message
     */
    public function testComposeMessageWithLineAvailable($message, $context, $expected)
    {
        $context['line'] = '223';

        $method = $this->get_accessible_reflection_method('compose_message');

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals($expected, $msg);
    }

    /**
     * Test message composition when file and line are set.
     *
     * @param String $message  The original log message
     * @param array  $context  Log message meta-data
     * @param String $expected Expected log message after replacing
     *
     * @depends      testInterpolateMessageReplacesPlaceholders
     * @dataProvider messageProvider
     * @covers       Lunr\Feedback\PHPLogger::compose_message
     */
    public function testComposeMessageWithFileAndLineAvailable($message, $context, $expected)
    {
        $context['file'] = 'Test.php';
        $context['line'] = '223';

        $method = $this->get_accessible_reflection_method('compose_message');

        $msg = $method->invokeArgs($this->class, array($message, $context));

        $this->assertEquals($expected . ' (Test.php: 223)', $msg);
    }

    /**
     * Test that log() returns a PHP Error.
     *
     * @param String $level              PSR-3 Log Level
     * @param String $expected_exception Expected PHPUnit Exception as string
     *
     * @dataProvider logLevelProvider
     * @covers       Lunr\Feedback\PHPLogger::log
     */
    public function testLogReturnsError($level, $expected_exception)
    {
        $this->setExpectedException($expected_exception);

        $this->class->log($level, 'msg');
    }

    /**
     * Test that log() returns a string when an object is passed as message.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\Feedback\PHPLogger::log
     */
    public function testLogReturnsStringWhenObjectPassedAsMessage()
    {
        $object = new MockLogMessage();

        $this->class->log(LogLevel::WARNING, $object);
    }

    /**
     * Unit test data provider for log messages.
     *
     * @return array $messages Array of log messages
     */
    public function messageProvider()
    {
        $messages   = array();
        $messages[] = array('{test} msg', array('test' => 'value'), 'value msg');
        $messages[] = array('{test} msg, {test1}', array('test' => 'value', 'test1' => 1), 'value msg, 1');

        return $messages;
    }

    /**
     * Unit test data provider for log levels.
     *
     * @return array levels Array of lof levels.
     */
    public function logLevelProvider()
    {
        $levels   = array();
        $levels[] = array(LogLevel::EMERGENCY, 'PHPUnit_Framework_Error');
        $levels[] = array(LogLevel::ALERT, 'PHPUnit_Framework_Error');
        $levels[] = array(LogLevel::CRITICAL, 'PHPUnit_Framework_Error');
        $levels[] = array(LogLevel::ERROR, 'PHPUnit_Framework_Error');
        $levels[] = array(LogLevel::WARNING, 'PHPUnit_Framework_Error_Warning');
        $levels[] = array(LogLevel::NOTICE, 'PHPUnit_Framework_Error_Notice');
        $levels[] = array(LogLevel::INFO, 'PHPUnit_Framework_Error_Notice');
        $levels[] = array(LogLevel::DEBUG, 'PHPUnit_Framework_Error_Notice');
        $levels[] = array('whatever', 'PHPUnit_Framework_Error_Notice');

        return $levels;
    }

}

?>
