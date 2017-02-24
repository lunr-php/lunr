<?php

/**
 * This file contains the FeedTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Feed;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook Feed class.
 *
 * @covers Lunr\Spark\Facebook\Feed
 */
abstract class FeedTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var \Lunr\Spark\CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Mock instance of the Logger class
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests_Response class.
     * @var \Requests_Response
     */
    protected $response;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMockBuilder('Lunr\Spark\CentralAuthenticationStore')->getMock();
        $this->http     = $this->getMockBuilder('Requests_Session')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->class      = new Feed($this->cas, $this->logger, $this->http);
        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Feed');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->cas);
        unset($this->http);
        unset($this->logger);
        unset($this->response);
    }

}

?>
