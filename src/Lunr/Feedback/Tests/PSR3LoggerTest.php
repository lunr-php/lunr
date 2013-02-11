<?php

/**
 * This file contains the PSR3LoggerTest class.
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

use Lunr\Feedback\PSR3Logger;
use Psr\Log\LogLevel;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the PSR3Logger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Feedback\PSR3Logger
 */
class PSR3LoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the PHPLogger class.
     * @var PHPLogger
     */
    private $logger;

    /**
     * Reflection-instance of the PHPLogger class.
     * @var ReflectionClass
     */
    private $logger_reflection;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->logger_reflection = new ReflectionClass('Lunr\Feedback\PSR3Logger');

        $this->logger = $this->getMockForAbstractClass('Lunr\Feedback\PSR3Logger');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger_reflection);
        unset($this->logger);
    }

    /**
     * Test that emergency forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::emergency
     */
    public function testEmergency()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::EMERGENCY),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->emergency('msg', array('test' => 'value'));
    }

    /**
     * Test that alert forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::alert
     */
    public function testAlert()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::ALERT),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->alert('msg', array('test' => 'value'));
    }

    /**
     * Test that critical forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::critical
     */
    public function testCritical()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::CRITICAL),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->critical('msg', array('test' => 'value'));
    }

    /**
     * Test that error forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::error
     */
    public function testError()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::ERROR),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->error('msg', array('test' => 'value'));
    }

    /**
     * Test that warning forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::warning
     */
    public function testWarning()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::WARNING),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->warning('msg', array('test' => 'value'));
    }

    /**
     * Test that notice forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::notice
     */
    public function testNotice()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::NOTICE),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->notice('msg', array('test' => 'value'));
    }

    /**
     * Test that info forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::info
     */
    public function testInfo()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::INFO),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->info('msg', array('test' => 'value'));
    }

    /**
     * Test that debug forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::debug
     */
    public function testDebug()
    {
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::DEBUG),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->logger->debug('msg', array('test' => 'value'));
    }

}

?>
