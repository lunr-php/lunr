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
    public function testDispatchReturnsNull(): void
    {
        $value = $this->class->dispatch('job', []);

        $this->assertNull($value);
    }

    /**
     * Test that dispatch_in() returns null.
     *
     * @covers Lunr\Spawn\NullDispatcher::dispatch_in
     */
    public function testDispatchInReturnsNull(): void
    {
        $value = $this->class->dispatch_in(30, 'job', []);

        $this->assertNull($value);
    }

    /**
     * Test that dispatch_at() returns null.
     *
     * @covers Lunr\Spawn\NullDispatcher::dispatch_at
     */
    public function testDispatchAtReturnsNull(): void
    {
        $value = $this->class->dispatch_at(time(), 'job', []);

        $this->assertNull($value);
    }

    /**
     * Test that get_job_id() returns null.
     *
     * @covers Lunr\Spawn\NullDispatcher::get_job_id
     */
    public function testGetJobIdReturnsNull(): void
    {
        $value = $this->class->get_job_id();

        $this->assertNull($value);
    }

    /**
     * Test that set_queue() returns the NullDispatcher's self reference.
     *
     * @covers Lunr\Spawn\NullDispatcher::set_queue
     */
    public function testSetQueueReturnsSelfReference(): void
    {
        $value = $this->class->set_queue('queue');

        $this->assertSame($value, $this->class);
    }

    /**
     * Test that set_track_status() returns the NullDispatcher's self reference.
     *
     * @covers Lunr\Spawn\NullDispatcher::set_track_status
     */
    public function testSetTrackStatusReturnsSelfReference(): void
    {
        $value = $this->class->set_track_status(FALSE);

        $this->assertSame($value, $this->class);
    }

}
?>
