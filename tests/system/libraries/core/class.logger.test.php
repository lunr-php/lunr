<?php

/**
 * This file contains the LoggerTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Logger class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Logger
 */
class LoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Logger Class.
     * @var Logger
     */
    private $logger;

    /**
     * Reflection instance of the Logger class.
     * @var ReflectionClass
     */
    private $logger_reflection;

    /**
     * DateTime string used for Logging Output.
     * @var String
     */
    const DATETIME_STRING = '2011-11-10 10:30:22';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $datetime = $this->getMock('Lunr\Libraries\Core\DateTime');
        $datetime->expects($this->once())
                 ->method('set_datetime_format')
                 ->will($this->returnValue(TRUE));
        $datetime->expects($this->any())
                 ->method('get_datetime')
                 ->will($this->returnValue(self::DATETIME_STRING));

        $request = $this->getMockBuilder('Lunr\Libraries\Core\Request')
                        ->disableOriginalConstructor()
                        ->getMock(array('__get'));

        $this->logger = new Logger($datetime, $request);

        $this->logger_reflection = new ReflectionClass('Lunr\Libraries\Core\Logger');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->logger_reflection);
    }

    /**
     * Test the default error message construction.
     *
     * @covers Lunr\Libraries\Core\Logger::construct_error_message
     */
    public function test_construct_error_message_from_prefix_and_message()
    {
        $info = 'Info';

        $output = '[' . self::DATETIME_STRING . ']: ' . $info;

        $method = $this->logger_reflection->getMethod('construct_error_message');
        $method->setAccessible(TRUE);

        $msg = $method->invokeArgs($this->logger, array($info));

        $this->assertInternalType('array', $msg);
        $this->assertEquals($info, $msg[0]);
        $this->assertEquals($output, $msg[1]);
    }

    /**
     * Test error message construction when only controller is set.
     *
     * @covers Lunr\Libraries\Core\Logger::construct_error_message
     */
    public function test_construct_error_message_with_controller_available()
    {
        $info = 'Info';

        $output = '[' . self::DATETIME_STRING . ']: ' . $info;

        $method = $this->logger_reflection->getMethod('construct_error_message');
        $method->setAccessible(TRUE);

        $request = $this->getMockBuilder('Lunr\Libraries\Core\Request')
                        ->disableOriginalConstructor()
                        ->getMock(array('__get'));
        $request->expects($this->at(0))
                ->method('__get')
                ->with($this->equalTo('controller'))
                ->will($this->returnValue('controller'));
        $request->expects($this->at(1))
                ->method('__get')
                ->with($this->equalTo('method'))
                ->will($this->returnValue(NULL));

        $property = $this->logger_reflection->getProperty('request');
        $property->setAccessible(TRUE);
        $property->setValue($this->logger, $request);

        $msg = $method->invokeArgs($this->logger, array($info));

        $this->assertInternalType('array', $msg);
        $this->assertEquals($info, $msg[0]);
        $this->assertEquals($output, $msg[1]);
    }

    /**
     * Test error message construction when only method is set.
     *
     * @covers Lunr\Libraries\Core\Logger::construct_error_message
     */
    public function test_construct_error_message_with_method_available()
    {
        $info = 'Info';

        $output = '[' . self::DATETIME_STRING . ']: ' . $info;

        $method = $this->logger_reflection->getMethod('construct_error_message');
        $method->setAccessible(TRUE);

        $request = $this->getMockBuilder('Lunr\Libraries\Core\Request')
                        ->disableOriginalConstructor()
                        ->getMock(array('__get'));
        $request->expects($this->once())
                ->method('__get')
                ->will($this->returnValue(NULL));

        $property = $this->logger_reflection->getProperty('request');
        $property->setAccessible(TRUE);
        $property->setValue($this->logger, $request);

        $msg = $method->invokeArgs($this->logger, array($info));

        $this->assertInternalType('array', $msg);
        $this->assertEquals($info, $msg[0]);
        $this->assertEquals($output, $msg[1]);
    }

    /**
     * Test error message construction when controller and method are set.
     *
     * @covers Lunr\Libraries\Core\Logger::construct_error_message
     */
    public function test_construct_error_message_with_controller_and_method_available()
    {
        $info = 'Info';

        $output = '[' . self::DATETIME_STRING . ']: controller/method: ' . $info;

        $method = $this->logger_reflection->getMethod('construct_error_message');
        $method->setAccessible(TRUE);

        $request = $this->getMockBuilder('Lunr\Libraries\Core\Request')
                        ->disableOriginalConstructor()
                        ->getMock(array('__get'));
        $request->expects($this->exactly(4))
                ->method('__get')
                ->will($this->returnArgument(0));

        $property = $this->logger_reflection->getProperty('request');
        $property->setAccessible(TRUE);
        $property->setValue($this->logger, $request);

        $msg = $method->invokeArgs($this->logger, array($info));

        $this->assertInternalType('array', $msg);
        $this->assertEquals('controller/method: ' . $info, $msg[0]);
        $this->assertEquals($output, $msg[1]);
    }

    /**
     * Test that log_error() returns a PHP Warning when no file is given.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers Lunr\Libraries\Core\Logger::log_error
     */
    public function test_log_error_returns_warning_without_file()
    {
        $this->logger->log_error('Foo');
    }

    /**
     * Test that log_errorln() returns a PHP Warning when no file is given.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers Lunr\Libraries\Core\Logger::log_errorln
     */
    public function test_log_errorln_returns_warning_without_file()
    {
        $this->logger->log_errorln('Foo');
    }

    /**
     * Test that log_error() returns a PHP Warning when no file is given.
     *
     * @depends test_construct_error_message_from_prefix_and_message
     * @covers  Lunr\Libraries\Core\Logger::log_error
     */
    public function test_log_error_to_file_prints_error()
    {
        $this->expectOutputRegex('/Xdebug: Foo(.)*/');
        $this->logger->log_error('Foo', '/dev/null');
    }

    /**
     * Test that log_errorln() returns a PHP Warning when no file is given.
     *
     * @depends test_construct_error_message_from_prefix_and_message
     * @covers Lunr\Libraries\Core\Logger::log_errorln
     */
    public function test_log_errorln_to_file_prints_error()
    {
        $this->expectOutputRegex('/Xdebug: Foo(.)*/');
        $this->logger->log_errorln('Foo', '/dev/null');
    }

    /**
     * Test that log_error() logs correctly to a file.
     *
     * @depends test_construct_error_message_from_prefix_and_message
     * @depends test_log_error_to_file_prints_error
     * @covers  Lunr\Libraries\Core\Logger::log_error
     */
    public function test_log_error_to_file()
    {
        $file = tempnam('/tmp', 'phpunit_');

        $this->expectOutputRegex('/Xdebug: Foo(.)*/');
        $this->logger->log_error('Foo', $file);

        $this->assertFileEquals(dirname(__FILE__) . '/../../../statics/logs/error.log', $file);
    }

    /**
     * Test that log_errorln() logs correctly to a file.
     *
     * @depends test_construct_error_message_from_prefix_and_message
     * @depends test_log_errorln_to_file_prints_error
     * @covers  Lunr\Libraries\Core\Logger::log_errorln
     */
    public function test_log_errorln_to_file()
    {
        $file = tempnam('/tmp', 'phpunit_');

        $this->expectOutputRegex('/Xdebug: Foo(.)*/');
        $this->logger->log_errorln('Foo', $file);

        $this->assertFileEquals(dirname(__FILE__) . '/../../../statics/logs/errorln.log', $file);
    }

}

?>
