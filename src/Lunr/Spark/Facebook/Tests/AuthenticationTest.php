<?php

/**
 * This file contains the AuthenticationTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Authentication;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Facebook\Authentication
 */
abstract class AuthenticationTest extends LunrBaseTest
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
     * Mock instance of the Request class.
     * @var \Lunr\Corona\RequestInterface
     */
    protected $request;

    /**
     * Mock instance of the Requests_Response class.
     * @var \Requests_Response
     */
    protected $response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpNull()
    {
        $this->cas      = $this->getMockBuilder('Lunr\Spark\CentralAuthenticationStore')->getMock();
        $this->http     = $this->getMockBuilder('Requests_Session')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->request  = $this->getMockBuilder('Lunr\Corona\RequestInterface')->getMock();
        $this->response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->request->expects($this->at(0))
                      ->method('get_get_data')
                      ->with($this->equalTo('state'))
                      ->will($this->returnValue(NULL));

        $this->class      = new Authentication($this->cas, $this->logger, $this->http, $this->request);
        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Authentication');
    }

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMockBuilder('Lunr\Spark\CentralAuthenticationStore')->getMock();
        $this->http     = $this->getMockBuilder('Requests_Session')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->request  = $this->getMockBuilder('Lunr\Corona\RequestInterface')->getMock();
        $this->response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->request->expects($this->at(0))
                      ->method('get_get_data')
                      ->with($this->equalTo('state'))
                      ->will($this->returnValue('String'));

        $this->request->expects($this->at(1))
                      ->method('get_get_data')
                      ->with($this->equalTo('code'))
                      ->will($this->returnValue('String'));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->will($this->onConsecutiveCalls('http://localhost/', 'controller/method/'));

        $this->class      = new Authentication($this->cas, $this->logger, $this->http, $this->request);
        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Authentication');
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
        unset($this->request);
        unset($this->response);
    }

    /**
     * Unit test data provider for scope values.
     *
     * @return array $values Array of scope values
     */
    public function scopeValueProvider()
    {
        $values   = [];
        $values[] = [ 'email,various', 'email,various' ];
        $values[] = [ [ 'email', 'various'], 'email,various' ];

        return $values;
    }

    /**
     * Unit test data provider for state values.
     *
     * @return array $values Array of state values.
     */
    public function stateValueProvider()
    {
        $values   = [];
        $values[] = [ 'valid', TRUE ];
        $values[] = [ 'invalid', FALSE ];

        return $values;
    }

}

?>
