<?php

/**
 * This file contains the FileTimerStopTest class.
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
 * This class contains test for stopping and deleting timers.
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Ticks\FileTimer
 */
class FileTimerStopTest extends FileTimerTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpNoRequest();
    }

    /**
     * Test stopping a non-existing timer returns FALSE.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testStopWithNonExistantIDReturnsFalse()
    {
        $this->assertFalse($this->class->stop('id'));
    }

    /**
     * Test stopping an existing timer returns TRUE.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testStopWithExistingIDReturnsTrue()
    {
        $timers = [ 'id' => [ 'stopped' => TRUE ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->assertTrue($this->class->stop('id'));
    }

    /**
     * Test stopping an already stopped timer does not alter stop time.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testStopStoppedTimerDoesNotChangeStopTime()
    {
        $timers = [ 'id' => [ 'stop' => 1372115612.4691,  'stopped' => TRUE ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->class->stop('id');

        $stoptime = $this->get_reflection_property_value('timers')['id']['stop'];

        $this->assertEquals(1372115612.4691, $stoptime);
    }

    /**
     * Test stopping a timer updates timer information.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testStopUpdatesTimerInformation()
    {
        $timers = [ 'id' => [ 'stopped' => FALSE ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->class->stop('id');

        $timer = $this->get_reflection_property_value('timers')['id'];

        $this->assertArrayHasKey('stop', $timer);
        $this->assertArrayHasKey('stopped', $timer);

        $this->assertInternalType('float', $timer['stop']);
        $this->assertTrue($timer['stopped']);
    }

    /**
     * Test stopping all timers returns TRUE.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testStopAllReturnsTrue()
    {
        $this->assertTrue($this->class->stop_all());
    }

    /**
     * Test stopping all timers stops all not already stopped timers.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testStopAllStopsNotStoppedTimers()
    {
        $timers = [ 'id' => [ 'stopped' => FALSE ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->class->stop_all();

        $timer = $this->get_reflection_property_value('timers')['id'];

        $this->assertArrayHasKey('stop', $timer);
        $this->assertArrayHasKey('stopped', $timer);

        $this->assertInternalType('float', $timer['stop']);
        $this->assertTrue($timer['stopped']);
    }

    /**
     * Test stopping all timers does not alter information of already stopped timers.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testStopAllDoesNotAlterAlreadyStoppedTimers()
    {
        $timers = [ 'id' => [ 'stop' => 1372115612.4691,  'stopped' => TRUE ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->class->stop_all();

        $stoptime = $this->get_reflection_property_value('timers')['id']['stop'];

        $this->assertEquals(1372115612.4691, $stoptime);
    }

    /**
     * Test deleting a non-existing timer returns FALSE.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testDeleteWithNonExistantIDReturnsFalse()
    {
        $this->assertFalse($this->class->delete('id'));
    }

    /**
     * Test deleting an existing timer returns TRUE.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testDeleteWithExistingIDReturnsTrue()
    {
        $timers = [ 'id' => [] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->assertTrue($this->class->delete('id'));
    }

    /**
     * Test deleting a timer removes timer information.
     *
     * @covers Lunr\Ticks\FileTimer::stop
     */
    public function testDeleteRemovesTimerInformation()
    {
        $timers = [ 'id' => [] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->class->delete('id');

        $timers = $this->get_reflection_property_value('timers');

        $this->assertArrayNotHasKey('id', $timers);
    }

}

?>
