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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Lunr\Feedback\PSR3Logger;
use Psr\Log\LogLevel;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the PSR3Logger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Feedback\PSR3Logger
 */
class PSR3LoggerTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->reflection = new ReflectionClass('Lunr\Feedback\PSR3Logger');

        $this->class = $this->getMockForAbstractClass('Lunr\Feedback\PSR3Logger');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Test that emergency forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::emergency
     */
    public function testEmergency()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::EMERGENCY),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->emergency('msg', array('test' => 'value'));
    }

    /**
     * Test that alert forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::alert
     */
    public function testAlert()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::ALERT),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->alert('msg', array('test' => 'value'));
    }

    /**
     * Test that critical forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::critical
     */
    public function testCritical()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::CRITICAL),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->critical('msg', array('test' => 'value'));
    }

    /**
     * Test that error forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::error
     */
    public function testError()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::ERROR),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->error('msg', array('test' => 'value'));
    }

    /**
     * Test that warning forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::warning
     */
    public function testWarning()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::WARNING),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->warning('msg', array('test' => 'value'));
    }

    /**
     * Test that notice forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::notice
     */
    public function testNotice()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::NOTICE),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->notice('msg', array('test' => 'value'));
    }

    /**
     * Test that info forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::info
     */
    public function testInfo()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::INFO),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->info('msg', array('test' => 'value'));
    }

    /**
     * Test that debug forwards the parameters to log correctly.
     *
     * @covers Lunr\Feedback\PSR3Logger::debug
     */
    public function testDebug()
    {
        $this->class->expects($this->once())
                     ->method('log')
                     ->with($this->equalTo(LogLevel::DEBUG),
                            $this->equalTo('msg'),
                            $this->equalTo(array('test' => 'value'))
                     );

        $this->class->debug('msg', array('test' => 'value'));
    }

}

?>
