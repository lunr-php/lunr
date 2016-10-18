<?php

/**
 * This file contains the GCMDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\GCM\GCMDispatcher;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GCMDispatcher class.
 *
 * @covers Lunr\Vortex\GCM\GCMDispatcher
 */
abstract class GCMDispatcherTest extends LunrBaseTest
{
    /**
     * Mock instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Mock instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->http   = $this->getMock('Requests_Session');
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = new GCMDispatcher($this->http, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
