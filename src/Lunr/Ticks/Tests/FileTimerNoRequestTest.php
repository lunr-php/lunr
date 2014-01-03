<?php

/**
 * This file contains the FileTimerNoRequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Ticks\Tests;

/**
 * This class contains test for the FileTimer when there is no Request information.
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Ticks\FileTimer
 */
class FileTimerNoRequestTest extends FileTimerTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpNoRequest();
    }

    /**
     * Test that Request is passed and constructed correctly.
     */
    public function testRequestIsEmptyString()
    {
        $this->assertEquals('', $this->get_reflection_property_value('request'));
    }

    /**
     * Test flushing single timer information without request info.
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

        $string = "[$date]: " . $expected;

        $this->file->expects($this->once())
                   ->method('fwrite')
                   ->with($this->equalTo($string));

        $this->class->flush();
    }

    /**
     * Test flushing multiple timer information without request info.
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
            $string .= "[$date]: " . $value;
        }

        $this->file->expects($this->once())
                   ->method('fwrite')
                   ->with($this->equalTo($string));

        $this->class->flush();
    }

    /**
     * Test flushing single not-stopped timer.
     *
     * @param Array  $timer    Array of single timer information
     * @param String $expected Expected String information
     *
     * @dataProvider singleTimerProvider
     * @covers       Lunr\Ticks\FileTimer::flush
     */
    public function testFlushSingleNotStoppedTimerDoesNotWriteToFile($timer, $expected)
    {
        $timer['single']['stopped'] = FALSE;
        $this->set_reflection_property_value('timers', $timer);

        $date = '2013-06-13 12:00:00';

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue($date));

        $this->file->expects($this->never())
                   ->method('fwrite');

        $this->class->flush();
    }

    /**
     * Test flushing multiple timer with one not being stopped.
     *
     * @param Array $timer    Array of multiple timer information
     * @param Array $expected Expected String information
     *
     * @dataProvider multipleTimerProvider
     * @covers       Lunr\Ticks\FileTimer::flush
     */
    public function testFlushMultipleWithOneNotStoppedTimerWritesOnlyPartiallyToFile($timer, $expected)
    {
        $timer[0]['stopped'] = FALSE;
        $this->set_reflection_property_value('timers', $timer);

        $date = '2013-06-13 12:00:00';

        $this->datetime->expects($this->once())
                       ->method('get_datetime')
                       ->will($this->returnValue($date));

        $string = "[$date]: " . $expected[1];

        $this->file->expects($this->once())
                   ->method('fwrite')
                   ->with($this->equalTo($string));

        $this->class->flush();
    }

    /**
     * Test flushing a timer deletes timer information.
     *
     * @param Array $timer Array of single timer information
     *
     * @dataProvider singleTimerProvider
     * @covers       Lunr\Ticks\FileTimer::flush
     */
    public function testFlushDeletesFlushedTimers($timer)
    {
        $this->set_reflection_property_value('timers', $timer);

        $this->class->flush();

        $timers = $this->get_reflection_property_value('timers');

        $this->assertArrayEmpty($timers);
    }

}

?>
