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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Lunr\Feedback\FileLogger;
use Psr\Log\LogLevel;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the FileLogger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Feedback\FileLogger
 */
class FileLoggerTest extends LunrBaseTest
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
     * Mock instance of the FilesystemAccessObject class
     * @var FilesystemAccessObjectInterface
     */
    private $fao;

    /**
     * Log-file name.
     * @var String
     */
    private $filename;

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
        $this->reflection = new ReflectionClass('Lunr\Feedback\FileLogger');

        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $this->datetime = $this->getMock('Lunr\Core\DateTime');

        $this->datetime->expects($this->once())
                       ->method('set_datetime_format')
                       ->with($this->equalTo('%Y-%m-%d %H:%M:%S'));

        $this->fao = $this->getMock('Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface');

        $this->filename = tempnam('/tmp', 'phpunit_');

        $this->class = new FileLogger($this->filename, $this->datetime, $this->request, $this->fao);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->datetime);
        unset($this->reflection);
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
     * Test that the datetime class is set correctly.
     */
    public function testDatetimeSetCorrectly()
    {
        $this->assertPropertySame('datetime', $this->datetime);
    }

    /**
     * Test that the filename is set correctly.
     */
    public function testFilenameSetCorrectly()
    {
        $this->assertPropertyEquals('filename', $this->filename);
    }

    /**
     * Test that log() logs correctly to a file.
     *
     * @covers Lunr\Feedback\FileLogger::log
     */
    public function testLogPutsMessageInFile()
    {
        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $this->fao->expects($this->once())
                  ->method('put_file_content')
                  ->with($this->equalTo($this->filename), $this->equalTo("[2011-11-10 10:30:22]: WARNING: Foo\n"), $this->equalTo(TRUE));

        $this->class->log(LogLevel::WARNING, 'Foo');
    }

    /**
     * Test that log() returns a string when an object is passed as message.
     *
     * @covers Lunr\Feedback\PHPLogger::log
     */
    public function testLogReturnsStringWhenObjectPassedAsMessage()
    {
        $object = new MockLogMessage();

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $this->fao->expects($this->once())
                  ->method('put_file_content')
                  ->with($this->equalTo($this->filename), $this->equalTo("[2011-11-10 10:30:22]: WARNING: Foo\n"), $this->equalTo(TRUE));

        $this->class->log(LogLevel::WARNING, $object);
    }

}

?>
