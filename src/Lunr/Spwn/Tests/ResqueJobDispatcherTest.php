<?php

/**
 * This file contains the ResqueJobDispatcherTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spwn
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spwn\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Lunr\Spwn\ResqueJobDispatcher;

/**
 * This class contains test methods for the ResqueJobDispatcher class.
 *
 * @category   Libraries
 * @package    Spwn
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Spwn\ResqueJobDispatcher
 */
class ResqueJobDispatcherTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the ResqueJobdispatcher class.
     * @var ResqueJobDispatcher
     */
    protected $dispatcher;

    /**
     * Reflection instance of the ResqueJobdispatcher class.
     * @var ReflectionClass
     */
    protected $dispatcher_reflection;

    /**
     * The resque instance of this test case.
     * @var Resque
     */
    protected $resque;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->resque = $this->getMock('Resque', array('enqueue'));

        $this->dispatcher_reflection = new ReflectionClass('Lunr\Spwn\ResqueJobDispatcher');
        $this->dispatcher            = new ResqueJobDispatcher($this->resque);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->dispatcher_reflection);
        unset($this->dispatcher);
        unset($this->resque);
    }

    /**
     * Unit Test Data Provider for invalid queue values.
     *
     * @return array $queues Array of invalid queue names
     */
    public function invalidQueueProvider()
    {
        $queues   = array();
        $queues[] = array(0);
        $queues[] = array(1);
        $queues[] = array(TRUE);
        $queues[] = array(FALSE);
        $queues[] = array(NULL);
        $queues[] = array(25.89);

        return $queues;
    }

    /**
     * Unit Test Data Provider for valid status values.
     *
     * @return array $statuses Array of valid status names
     */
    public function validTrackStatusProvider()
    {
        $statuses   = array();
        $statuses[] = array(TRUE);
        $statuses[] = array(FALSE);

        return $statuses;
    }

    /**
     * Unit Test Data Provider for invalid status values.
     *
     * @return array $statuses Array of invalid status names
     */
    public function invalidTrackStatusProvider()
    {
        $statuses   = array();
        $statuses[] = array(0);
        $statuses[] = array(1);
        $statuses[] = array('str');
        $statuses[] = array(NULL);
        $statuses[] = array(25.89);

        return $statuses;
    }

    /**
     * Tests that __construct() inits the resque with the given parameter.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::__construct
     */
    public function testResqueInitsWithValue()
    {
        $property = $this->dispatcher_reflection->getProperty('resque');
        $property->setAccessible(TRUE);

        $this->assertSame($this->resque, $property->getValue($this->dispatcher));

    }

    /**
     * Tests that __construct() inits the queue with the 'default_queue' value.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::__construct
     */
    public function testQueueInitsWithDefaultValue()
    {
        $property = $this->dispatcher_reflection->getProperty('queue');
        $property->setAccessible(TRUE);

        $this->assertEquals('default_queue', $property->getValue($this->dispatcher));

    }

    /**
     * Tests that __construct() inits the track status to FALSE.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::__construct
     */
    public function testTrackStatusInitsWithDefaultValue()
    {
        $property = $this->dispatcher_reflection->getProperty('track_status');
        $property->setAccessible(TRUE);

        $this->assertTrue(FALSE === $property->getValue($this->dispatcher));

    }

    /**
     * Tests that the token propery is NULL by default.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::__construct
     */
    public function testTokenIsNullBydefault()
    {
        $property = $this->dispatcher_reflection->getProperty('token');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->dispatcher));
    }

    /**
     * Test that dispatch() returns a string if queue is set.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::dispatch
     */
    public function testDispatchUpdateToken()
    {
        $this->resque->expects($this->any())
             ->method('enqueue')
             ->will($this->returnValue('TOKEN'));

        $property = $this->dispatcher_reflection->getProperty('token');
        $property->setAccessible(TRUE);

        $this->dispatcher->dispatch('job', array());

        $this->assertNotNull($property->getValue($this->dispatcher));
    }

    /**
     * Tests that the get_job_id() method retrieves the token.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::get_job_id
     */
    public function testGetJobIdReturnsToken()
    {
        $this->resque->expects($this->any())
             ->method('enqueue')
             ->will($this->returnValue('TOKEN'));

        $property = $this->dispatcher_reflection->getProperty('token');
        $property->setAccessible(TRUE);

        $this->dispatcher->dispatch('job', array());

        $this->assertSame($property->getValue($this->dispatcher), $this->dispatcher->get_job_id());
    }

    /**
     * Tests that set_queue() modifies the queue property with a valid value.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::set_queue
     */
    public function testSetQueue()
    {
        $property = $this->dispatcher_reflection->getProperty('queue');
        $property->setAccessible(TRUE);

        $value = 'queue';

        $this->dispatcher->set_queue($value);

        $this->assertSame($value, $property->getValue($this->dispatcher));
    }

    /**
     * Tests that set_queue() does not modify the queue property with invalid value.
     *
     * @param mixed $value the value to test
     *
     * @dataProvider invalidQueueProvider
     * @covers       Lunr\Spwn\ResqueJobDispatcher::set_queue
     */
    public function testSetQueueWithInvalidValue($value)
    {
        $property = $this->dispatcher_reflection->getProperty('queue');
        $property->setAccessible(TRUE);

        $this->dispatcher->set_queue($value);

        $this->assertNotSame($value, $property->getValue($this->dispatcher));
    }

    /**
     * Tests that set_track_status() modifies the track status property with valid value.
     *
     * @param Boolean $value the value to test
     *
     * @dataProvider validTrackStatusProvider
     * @covers       Lunr\Spwn\ResqueJobDispatcher::set_track_status
     */
    public function testSetTrackStatusWithValidValue($value)
    {
        $property = $this->dispatcher_reflection->getProperty('track_status');
        $property->setAccessible(TRUE);

        $value = TRUE;
        $this->dispatcher->set_track_status($value);

        $this->assertSame($value, $property->getValue($this->dispatcher));
    }

    /**
     * Tests that set_track_status() does not modify the track status property with invalid value.
     *
     * @param mixed $value the value to test
     *
     * @dataProvider invalidTrackStatusProvider
     * @covers       Lunr\Spwn\ResqueJobDispatcher::set_track_status
     */
    public function testSetTrackStatusWithInvalidValue($value)
    {
        $property = $this->dispatcher_reflection->getProperty('track_status');
        $property->setAccessible(TRUE);

        $this->dispatcher->set_track_status($value);

        $this->assertNotSame($value, $property->getValue($this->dispatcher));
    }

    /**
     * Test fluid interface of the set_queue method.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::set_queue
     */
    public function testSetQueueReturnsSelfReference()
    {
        $this->assertSame($this->dispatcher, $this->dispatcher->set_queue('queue'));
    }

    /**
     * Test fluid interface of the set_track_status method.
     *
     * @covers Lunr\Spwn\ResqueJobDispatcher::set_track_status
     */
    public function testSetTrackStatusReturnsSelfReference()
    {
        $this->assertSame($this->dispatcher, $this->dispatcher->set_track_status(TRUE));
    }

}

?>
