<?php

/**
 * This file contains the PHPLoggerTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2017, M2Mobi BV, Amsterdam, The Netherlands
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
 * @covers Lunr\Feedback\PHPLogger
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
