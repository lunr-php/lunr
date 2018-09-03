<?php

/**
 * This file contains the ResqueJobDispatcherTest class.
 *
 * @package    Lunr\Spawn
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use Lunr\Spawn\ResqueJobDispatcher;

/**
 * This class contains test set up and the data providers for the ResqueJobDispatcher class.
 *
 * @covers Lunr\Spawn\ResqueJobDispatcher
 */
class ResqueJobDispatcherTest extends LunrBaseTest
{

    /**
     * Instance of the LunrBaseTest class.
     * @var ResqueJobDispatcher
     */
    protected $class;

    /**
     * Reflection instance of the LunrBaseTest class.
     * @var ReflectionClass
     */
    protected $reflection;

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
        $this->resque = $this->getMockBuilder('Resque')->getMock();

        $this->reflection = new ReflectionClass('Lunr\Spawn\ResqueJobDispatcher');
        $this->class      = new ResqueJobDispatcher($this->resque);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
        unset($this->resque);
    }

    /**
     * Unit Test Data Provider for invalid queue values.
     *
     * @return array $queues Array of invalid queue names
     */
    public function invalidQueueProvider()
    {
        $queues   = [];
        $queues[] = [ 0 ];
        $queues[] = [ 1 ];
        $queues[] = [ TRUE ];
        $queues[] = [ FALSE ];
        $queues[] = [ NULL ];
        $queues[] = [ 25.89 ];
        $queues[] = [ [ 123 ] ];
        $queues[] = [ [ TRUE ] ];
        $queues[] = [ [ NULL ] ];

        return $queues;
    }

    /**
     * Unit Test Data Provider for valid status values.
     *
     * @return array $statuses Array of valid status names
     */
    public function validTrackStatusProvider()
    {
        $statuses   = [];
        $statuses[] = [ TRUE ];
        $statuses[] = [ FALSE ];

        return $statuses;
    }

    /**
     * Unit Test Data Provider for invalid status values.
     *
     * @return array $statuses Array of invalid status names
     */
    public function invalidTrackStatusProvider()
    {
        $statuses   = [];
        $statuses[] = [ 0 ];
        $statuses[] = [ 1 ];
        $statuses[] = [ 'str' ];
        $statuses[] = [ NULL ];
        $statuses[] = [ 25.89 ];

        return $statuses;
    }

}

?>
