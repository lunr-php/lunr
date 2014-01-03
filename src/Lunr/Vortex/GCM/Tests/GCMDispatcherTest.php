<?php

/**
 * This file contains the GCMDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\GCM\GCMDispatcher;
use Lunr\Vortex\GCM\GCMPriority;
use Lunr\Vortex\GCM\GCMType;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GCMDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Vortex\GCM\GCMDispatcher
 */
abstract class GCMDispatcherTest extends LunrBaseTest
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
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $config;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $sub_config;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->curl       = $this->getMock('Lunr\Network\Curl');
        $this->logger     = $this->getMock('Psr\Log\LoggerInterface');
        $this->config     = $this->getMock('Lunr\Core\Configuration');
        $this->sub_config = $this->getMock('Lunr\Core\Configuration');

        $map = [ 'gcm' => $this->sub_config ];

        $this->config->expects($this->any())
                     ->method('offsetGet')
                     ->will($this->returnValueMap($map));

        $map = ['google_send_url' => 'gcm_post_url'];

        $this->sub_config->expects($this->any())
                         ->method('offsetGet')
                         ->will($this->returnValueMap($map));

        $this->class = new GCMDispatcher($this->curl, $this->logger, $this->config);

        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->config);
        unset($this->sub_config);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
