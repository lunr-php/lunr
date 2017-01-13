<?php

/**
 * This file contains the ApiTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Api;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Facebook\Api
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
     * @var \Requests_Response
     */
    protected $response;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->http     = $this->getMock('Requests_Session');
        $this->logger   = $this->getMock('Psr\Log\LoggerInterface');
        $this->response = $this->getMock('Requests_Response');

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\Api')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->http ])
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
        unset($this->http);
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

    /**
     * Unit test data provider for request parameters.
     *
     * @return array $methods Array of request parameters
     */
    public function requestParamProvider()
    {
        $args   = [];
        $args[] = ['http://localhost'];
        $args[] = [
            'http://localhost',
            [ 'param1' => 1, 'param2' => 2 ],
        ];
        $args[] = [
            'http://localhost',
            [ 'param1' => 1, 'param2' => 2 ],
            'GET',
        ];
        $args[] = [
            'http://localhost',
            [ 'param1' => 1, 'param2' => 2 ],
            'get',
        ];
        $args[] = [
            'http://localhost',
            [],
            'POST',
        ];
        $args[] = [
            'http://localhost',
            [ 'param1' => 1, 'param2' => 2 ],
            'POST',
        ];
        $args[] = [
            'http://localhost',
            [ 'param1' => 1, 'param2' => 2 ],
            'post',
        ];

        return $args;
    }

}

?>
