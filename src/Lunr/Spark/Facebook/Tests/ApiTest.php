<?php

/**
 * This file contains the ApiTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Api;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Api.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Api
 */
abstract class ApiTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Mock instance of the Logger class
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the CurlResponse class.
     * @var CurlResponse
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

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\Api')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->curl ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Api');
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
     * Unit test data provider for general __get() keys.
     *
     * @return array $keys Array of keys
     */
    public function generalGetKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'app_id' ];
        $keys[] = [ 'app_secret' ];
        $keys[] = [ 'app_secret_proof' ];
        $keys[] = [ 'access_token' ];

        return $keys;
    }

    /**
     * Unit test data provider for general __set() keys.
     *
     * @return array $keys Array of keys
     */
    public function generalSetKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'app_id' ];
        $keys[] = [ 'app_secret' ];

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

    /**
     * Unit test data provider for non Array values.
     *
     * @return array $values Array of non array values
     */
    public function nonArrayProvider()
    {
        $values   = [];
        $values[] = [ 'string' ];
        $values[] = [ 0 ];
        $values[] = [ 1.1 ];
        $values[] = [ NULL ];
        $values[] = [ FALSE ];
        $values[] = [ new \stdClass() ];

        return $values;
    }

}

?>
