<?php

/**
 * This file contains the FileLoggerTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Lunr\Feedback\FileLogger;
use Psr\Log\LogLevel;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the FileLogger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Feedback\FileLogger
 */
class FileLoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock-instance of the Request class.
     * @var Request
     */
    private $request;

    /**
     * Mock-instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Instance of the PHPLogger class.
     * @var PHPLogger
     */
    private $logger;

    /**
     * Log-file name.
     * @var String
     */
    private $filename;

    /**
     * Reflection-instance of the PHPLogger class.
     * @var ReflectionClass
     */
    private $logger_reflection;

    /**
     * DateTime string used for Logging Output.
     * @var String
     */
    const DATETIME_STRING = '2011-11-10 10:30:22';

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->logger_reflection = new ReflectionClass('Lunr\Feedback\FileLogger');

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->datetime = $this->getMock('Lunr\Core\DateTime');

        $this->datetime->expects($this->once())
                       ->method('set_datetime_format')
                       ->with($this->equalTo('%Y-%m-%d %H:%M:%S'));

        $this->filename = tempnam('/tmp', 'phpunit_');

        $this->logger = new FileLogger($this->filename, $this->datetime, $this->request);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger_reflection);
        unset($this->logger);
        unset($this->request);
        unset($this->datetime);
    }

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly()
    {
        $property = $this->logger_reflection->getProperty('request');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->request, $property->getValue($this->logger));
        $this->assertSame($this->request, $property->getValue($this->logger));
    }

    /**
     * Test that the datetime class is set correctly.
     */
    public function testDatetimeSetCorrectly()
    {
        $property = $this->logger_reflection->getProperty('datetime');
        $property->setAccessible(TRUE);

        $this->assertInstanceOf('Lunr\Core\DateTime', $property->getValue($this->logger));
    }

    /**
     * Test that the filename is set correctly.
     */
    public function testFilenameSetCorrectly()
    {
        $property = $this->logger_reflection->getProperty('filename');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->filename, $property->getValue($this->logger));
    }

    /**
     * Test that log() returns a PHP Warning if xdebug is installed.
     *
     * @covers  Lunr\Feedback\FileLogger::log
     */
    public function testLogThrowsErrorIfXdebugIsPresent()
    {
        $property = $this->logger_reflection->getProperty('filename');
        $property->setAccessible(TRUE);

        $property->setValue($this->logger, '/dev/null');

        $this->expectOutputRegex('/^\nXdebug: WARNING: Foo/');
        $this->logger->log(LogLevel::WARNING, 'Foo');
    }

    /**
     * Test that log() logs correctly to a file.
     *
     * @depends testLogThrowsErrorIfXdebugIsPresent
     * @covers  Lunr\Feedback\FileLogger::log
     */
    public function testLogPutsMessageInFile()
    {
        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $this->expectOutputRegex('/^\nXdebug: WARNING: Foo/');
        $this->logger->log(LogLevel::WARNING, 'Foo');

        $this->assertFileEquals(dirname(__FILE__) . '/../../../../tests/statics/logs/errorln.log', $this->filename);
    }

    /**
     * Test that log() returns a string when an object is passed as message.
     *
     * @depends testLogThrowsErrorIfXdebugIsPresent
     * @covers  Lunr\Feedback\PHPLogger::log
     */
    public function testLogReturnsStringWhenObjectPassedAsMessage()
    {
        $object = new MockLogMessage();

        $this->expectOutputRegex('/^\nXdebug: WARNING: Foo/');

        $this->logger->log(LogLevel::WARNING, $object);
    }

}

?>
