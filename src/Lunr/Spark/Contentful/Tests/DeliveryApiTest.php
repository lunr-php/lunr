<?php

/**
 * This file contains the DeliveryApiTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Spark\Contentful\DeliveryApi;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DeliveryApi.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Contentful\DeliveryApi
 */
abstract class DeliveryApiTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Curl class.
     * @var \Lunr\Network\Curl
     */
    protected $curl;

    /**
     * Mock instance of the Logger class
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the CurlResponse class.
     * @var \Lunr\Network\CurlResponse
     */
    protected $response;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->curl     = $this->getMock('Lunr\Network\Curl');
        $this->logger   = $this->getMock('Psr\Log\LoggerInterface');
        $this->response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->class = new DeliveryApi($this->cas, $this->logger, $this->curl);

        $this->reflection = new ReflectionClass('Lunr\Spark\Contentful\DeliveryApi');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->cas);
        unset($this->curl);
        unset($this->logger);
        unset($this->response);
    }

    /**
     * Unit test data provider for general __get() __set() keys.
     *
     * @return array $keys Array of keys
     */
    public function generalKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'access_token' ];

        return $keys;
    }

    /**
     * Unit test data provider for get methods.
     *
     * @return array $methods Array of get methods
     */
    public function getMethodProvider()
    {
        $methods   = [];
        $methods[] = [ 'get' ];
        $methods[] = [ 'GET' ];

        return $methods;
    }

}

?>
