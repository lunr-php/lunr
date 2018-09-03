<?php

/**
 * This file contains the ApiTest class.
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Lunr\Spark\Twitter\Api;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Twitter\Api
 */
abstract class ApiTest extends LunrBaseTest
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
     * @var Requests_Response
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

        $this->class = $this->getMockBuilder('Lunr\Spark\Twitter\Api')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->http ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Spark\Twitter\Api');
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

    /**
     * Unit test data provider for general __get() __set() keys.
     *
     * @return array $keys Array of keys
     */
    public function generalKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'consumer_key' ];
        $keys[] = [ 'consumer_secret' ];
        $keys[] = [ 'user_agent' ];

        return $keys;
    }

    /**
     * Unit test data provider for request parameters.
     *
     * @return array $methods Array of request parameters
     */
    public function requestParamProvider()
    {
        $args   = [];
        $args[] = [ 'http://localhost' ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [ 'param1' => 1, 'param2' => 2 ],
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [ 'param1' => 1, 'param2' => 2 ],
            'GET',
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [ 'param1' => 1, 'param2' => 2 ],
            'GET',
            [ 'auth' => [ 'user', 'password' ] ],
        ];
        $args[] = [
            'http://localhost',
            [],
            [],
            'POST',
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [],
            'POST',
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [ 'param1' => 1, 'param2' => 2 ],
            'POST',
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [ 'param1' => 1, 'param2' => 2 ],
            'POST',
            [ 'auth' => [ 'user', 'password' ] ],
        ];
        $args[] = [
            'http://localhost',
            [],
            [],
            'post',
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [],
            'post',
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [ 'param1' => 1, 'param2' => 2 ],
            'post',
        ];
        $args[] = [
            'http://localhost',
            [ 'Content-Type' => 'application/json' ],
            [ 'param1' => 1, 'param2' => 2 ],
            'post',
            [ 'auth' => [ 'user', 'password' ] ],
        ];

        return $args;
    }

}

?>
