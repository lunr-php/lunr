<?php

/**
 * This file contains the ResqueJobDispatcherTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use Lunr\Spawn\ResqueJobDispatcher;

/**
 * This class contains test set up and the data providers for the ResqueJobDispatcher class.
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Spawn\ResqueJobDispatcher
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
        $this->resque = $this->getMock('Resque', array('enqueue'));

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
        $queues   = array();
        $queues[] = array(0);
        $queues[] = array(1);
        $queues[] = array(TRUE);
        $queues[] = array(FALSE);
        $queues[] = array(NULL);
        $queues[] = array(25.89);
        $queues[] = array(array(123));
        $queues[] = array(array(TRUE));
        $queues[] = array(array(NULL));

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

}

?>
