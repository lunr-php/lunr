<?php

/**
 * This file contains the ResqueJobDispatcherBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

use Lunr\Spawn\Tests\ResqueJobDispatcherTest;

/**
 * This class contains test methods for the ResqueJobDispatcher class.
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Spawn\ResqueJobDispatcher
 */
class ResqueJobDispatcherBaseTest extends ResqueJobDispatcherTest
{

    /**
     * Tests that __construct() inits the resque with the given parameter.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::__construct
     */
    public function testResqueInitsWithValue()
    {
        $value = $this->get_reflection_property_value('resque');

        $this->assertSame($this->resque, $value);
    }

    /**
     * Tests that __construct() inits the queue with the 'default_queue' value.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::__construct
     */
    public function testQueueInitsWithDefaultValue()
    {
        $value = $this->get_reflection_property_value('queue');

        $this->assertEquals(array('default_queue'), $value);

    }

    /**
     * Tests that __construct() inits the track status to FALSE.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::__construct
     */
    public function testTrackStatusInitsWithDefaultValue()
    {
        $value = $this->get_reflection_property_value('track_status');

        $this->assertFalse($value);

    }

    /**
     * Tests that the token propery is NULL by default.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::__construct
     */
    public function testTokenIsNullBydefault()
    {
        $value = $this->get_reflection_property_value('token');

        $this->assertNull($value);
    }

    /**
     * Test that dispatch() returns a string if queue is set.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::dispatch
     */
    public function testDispatchUpdateToken()
    {
        $this->resque->expects($this->any())
             ->method('enqueue')
             ->will($this->returnValue('TOKEN'));

        $this->class->dispatch('job', array());

        $value = $this->get_reflection_property_value('token');

        $this->assertNotNull($value);
    }

    /**
     * Tests that the get_job_id() method retrieves the token.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::get_job_id
     */
    public function testGetJobIdReturnsToken()
    {
        $this->resque->expects($this->any())
             ->method('enqueue')
             ->will($this->returnValue('TOKEN'));

        $this->class->dispatch('job', array());

        $value = $this->get_reflection_property_value('token');

        $this->assertSame($value, $this->class->get_job_id());
    }

    /**
     * Tests that set_queue() modifies the queue property with a valid value.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::set_queue
     */
    public function testSetQueueWithString()
    {
        $queue = 'queue';
        $this->class->set_queue($queue);

        $value = $this->get_reflection_property_value('queue');

        $this->assertSame(array($queue), $value);
    }

    /**
     * Tests that set_queue() with array input.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::set_queue
     */
    public function testSetQueueWithArray()
    {
        $queue = array('queue');
        $this->class->set_queue($queue);

        $value = $this->get_reflection_property_value('queue');

        $this->assertSame($value, $value);
    }

    /**
     * Tests that set_queue() does not modify the queue property with invalid value.
     *
     * @param mixed $queue Invalid Queue value
     *
     * @dataProvider invalidQueueProvider
     * @covers       Lunr\Spawn\ResqueJobDispatcher::set_queue
     */
    public function testSetQueueWithInvalidValue($queue)
    {
        $this->class->set_queue($queue);

        $value = $this->get_reflection_property_value('queue');

        $this->assertNotSame($queue, $value);
    }

    /**
     * Tests that set_track_status() modifies the track status property with valid value.
     *
     * @param Boolean $value the value to test
     *
     * @dataProvider validTrackStatusProvider
     * @covers       Lunr\Spawn\ResqueJobDispatcher::set_track_status
     */
    public function testSetTrackStatusWithValidValue($value)
    {
        $value = TRUE;
        $this->class->set_track_status($value);

        $status = $this->get_reflection_property_value('track_status');

        $this->assertSame($value, $status);
    }

    /**
     * Tests that set_track_status() does not modify the track status property with invalid value.
     *
     * @param mixed $value the value to test
     *
     * @dataProvider invalidTrackStatusProvider
     * @covers       Lunr\Spawn\ResqueJobDispatcher::set_track_status
     */
    public function testSetTrackStatusWithInvalidValue($value)
    {
        $this->class->set_track_status($value);

        $status = $this->get_reflection_property_value('track_status');

        $this->assertNotSame($value, $status);
    }

    /**
     * Test fluid interface of the set_queue method.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::set_queue
     */
    public function testSetQueueReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_queue('queue'));
    }

    /**
     * Test fluid interface of the set_track_status method.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::set_track_status
     */
    public function testSetTrackStatusReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_track_status(TRUE));
    }

}
?>
