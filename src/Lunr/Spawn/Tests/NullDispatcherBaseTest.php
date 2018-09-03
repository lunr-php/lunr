<?php

/**
 * This file contains the NullDispatcherBaseTest class.
 *
 * @package    Lunr\Spawn
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

/**
 * This class contains test methods for the NullDispatcher class.
 *
 * @covers Lunr\Spawn\NullDispatcher
 */
class NullDispatcherBaseTest extends NullDispatcherTest
{

    /**
     * Test that dispatch() returns null.
     *
     * @covers Lunr\Spawn\NullDispatcher::dispatch
     */
    public function testDispatchReturnsNull()
    {
        $value = $this->class->dispatch('job', []);

        $this->assertNull($value);
    }

    /**
     * Test that get_job_id() returns null.
     *
     * @covers Lunr\Spawn\NullDispatcher::get_job_id
     */
    public function testGetJobIdReturnsNull()
    {
        $value = $this->class->get_job_id();

        $this->assertNull($value);
    }

    /**
     * Test that set_queue() returns the NullDispatcher's self reference.
     *
     * @covers Lunr\Spawn\NullDispatcher::set_queue
     */
    public function testSetQueueReturnsSelfReference()
    {
        $value = $this->class->set_queue('queue');

        $this->assertSame($value, $this->class);
    }

    /**
     * Test that set_track_status() returns the NullDispatcher's self reference.
     *
     * @covers Lunr\Spawn\NullDispatcher::set_track_status
     */
    public function testSetTrackStatusReturnsSelfReference()
    {
        $value = $this->class->set_track_status(FALSE);

        $this->assertSame($value, $this->class);
    }

}
?>
