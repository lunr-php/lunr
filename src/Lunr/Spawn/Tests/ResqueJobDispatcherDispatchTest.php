<?php

/**
 * This file contains the ResqueJobDispatcherDispatchTest class.
 *
 * @package    Lunr\Spawn
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2019, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

use Lunr\Spawn\Tests\ResqueJobDispatcherTest;

/**
 * This class contains test methods for the ResqueJobDispatcher class.
 *
 * @covers Lunr\Spawn\ResqueJobDispatcher
 */
class ResqueJobDispatcherDispatchTest extends ResqueJobDispatcherTest
{

    /**
     * Test that dispatch() sets a token string if queue is set.
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::dispatch
     */
    public function testDispatchUpdateToken(): void
    {
        $this->mock_method([ $this->resque, 'enqueue' ], function () {return 'TOKEN';});

        $this->class->dispatch('job', []);

        $value = $this->get_reflection_property_value('token');

        $this->assertNotNull($value);

        $this->unmock_method([ $this->resque, 'enqueue' ]);
    }

    /**
     * Test dispatch_in().
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::dispatch_in
     */
    public function testDispatchIn(): void
    {
        $this->mock_method([ $this->scheduler, 'enqueueIn' ], function () {return NULL;});

        $value = $this->class->dispatch_in(30, 'job', []);

        $this->assertNull($value);

        $this->unmock_method([ $this->scheduler, 'enqueueIn' ]);
    }

    /**
     * Test dispatch_at().
     *
     * @covers Lunr\Spawn\ResqueJobDispatcher::dispatch_in
     */
    public function testDispatchAt(): void
    {
        $this->mock_method([ $this->scheduler, 'enqueueAt' ], function () {return NULL;});

        $value = $this->class->dispatch_at(time(), 'job', []);

        $this->assertNull($value);

        $this->unmock_method([ $this->scheduler, 'enqueueAt' ]);
    }

}

?>
