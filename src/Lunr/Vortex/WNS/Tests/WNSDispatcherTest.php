<?php

/**
 * This file contains the WNSDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSDispatcher;
use Lunr\Vortex\WNS\WNSPriority;
use Lunr\Vortex\WNS\WNSType;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSDispatcher class.
 *
 * @covers Lunr\Vortex\WNS\WNSDispatcher
 */
abstract class WNSDispatcherTest extends LunrBaseTest
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
     * Mock instance of the Configuration class.
     * @var \Lunr\Core\Configuration
     */
    protected $config;

    /**
     * Mock instance of the Requests_Response class.
     * @var \Requests_Response
     */
    protected $response;

    /**
     * Mock instance of the WNS Payload class.
     * @var WNSPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->http = $this->getMockBuilder('Requests_Session')->getMock();

        $this->response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->config = $this->getMockBuilder('Lunr\Core\Configuration')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\WNS\WNSPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new WNSDispatcher($this->http, $this->logger, $this->config);

        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->payload);
        unset($this->http);
        unset($this->logger);
        unset($this->config);
        unset($this->response);
    }

    /**
     * Unit test data provider for valid WNS Priorities.
     *
     * @return array $priorities Array of WNS priorities.
     */
    public function validPriorityProvider()
    {
        $priorities   = [];
        $priorities[] = [ WNSPriority::TILE_IMMEDIATELY ];
        $priorities[] = [ WNSPriority::TOAST_IMMEDIATELY ];
        $priorities[] = [ WNSPriority::RAW_IMMEDIATELY ];
        $priorities[] = [ WNSPriority::TILE_WAIT_450 ];
        $priorities[] = [ WNSPriority::TOAST_WAIT_450 ];
        $priorities[] = [ WNSPriority::RAW_WAIT_450 ];
        $priorities[] = [ WNSPriority::TILE_WAIT_900 ];
        $priorities[] = [ WNSPriority::TOAST_WAIT_900 ];
        $priorities[] = [ WNSPriority::RAW_WAIT_900 ];

        return $priorities;
    }

    /**
     * Unit test data provider for valid WNS Types.
     *
     * @return array $types Array of WNS types.
     */
    public function validTypeProvider()
    {
        $types   = [];
        $types[] = [ WNSType::TILE ];
        $types[] = [ WNSType::TOAST ];
        $types[] = [ WNSType::RAW ];
        $types[] = [ WNSType::BADGE ];

        return $types;
    }

}

?>
