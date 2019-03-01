<?php

/**
 * This file contains the FCMDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMDispatcher;
use Lunr\Vortex\FCM\FCMPriority;
use Lunr\Vortex\FCM\FCMType;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
abstract class FCMDispatcherTest extends LunrBaseTest
{
    /**
     * Mock instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->curl   = $this->getMock('Lunr\Network\Curl');
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = new FCMDispatcher($this->curl, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\FCM\FCMDispatcher');
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
