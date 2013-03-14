<?php

/**
 * This file contains the FileTimerRequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Ticks\Tests;

/**
 * This class contains test for the FileTimer when there is Request information.
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Ticks\FileTimer
 */
class FileTimerRequestTest extends FileTimerTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpRequest();
    }

    /**
     * Test that timers is initialized as an empty array.
     */
    public function testTimersIsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('timers'));
    }

    /**
     * Test that the timer ID counter is initialized as zero.
     */
    public function testCounterIsZero()
    {
        $this->assertEquals(0, $this->get_reflection_property_value('counter'));
    }

    /**
     * Test that SplFileObject is passed correctly.
     */
    public function testSplFileObjectIsPassedCorrectly()
    {
        $value = $this->get_reflection_property_value('file');

        $this->assertInstanceOf('SplFileObject', $value);
        $this->assertSame($this->file, $value);
    }

    /**
     * Test that DateTime is passed and setup correctly.
     */
    public function testDateTimeIsPassedCorrectly()
    {
        $value = $this->get_reflection_property_value('datetime');

        $this->assertInstanceOf('Lunr\Core\DateTime', $value);
        $this->assertSame($this->datetime, $value);
    }

    /**
     * Test that Request is passed and constructed correctly.
     */
    public function testRequestIsPassedCorrectly()
    {
        $value = $this->get_reflection_property_value('request');

        $this->assertEquals('controller/method: ', $value);
    }

    /**
     * Test flushing single timer information with request info.
     *
     * @param Array  $timer    Array of single timer information
     * @param String $expected Expected String information
     *
     * @dataProvider singleTimerProvider
     * @covers       Lunr\Ticks\FileTimer::flush
     */
    public function testFlushSingleTimerWithRequestInfo($timer, $expected)
    {
        $this->set_reflection_property_value('timers', $timer);

        $date = '2013-06-13 12:00:00';

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue($date));

        $string = "[$date]: controller/method: " . $expected;

        $this->file->expects($this->once())
                   ->method('fwrite')
                   ->with($this->equalTo($string));

        $this->class->flush();
    }

    /**
     * Test flushing multiple timer information with request info.
     *
     * @param Array $timer    Array of multiple timer information
     * @param Array $expected Expected String information
     *
     * @dataProvider multipleTimerProvider
     * @covers       Lunr\Ticks\FileTimer::flush
     */
    public function testFlushMultipleTimersWithRequestInfo($timer, $expected)
    {
        $this->set_reflection_property_value('timers', $timer);

        $date = '2013-06-13 12:00:00';

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue($date));

        $string = '';

        foreach ($expected as $value)
        {
            $string .= "[$date]: controller/method: " . $value;
        }

        $this->file->expects($this->once())
                   ->method('fwrite')
                   ->with($this->equalTo($string));

        $this->class->flush();
    }

}
