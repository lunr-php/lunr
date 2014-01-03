<?php

/**
 * This file contains the AuthenticationTest class.
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

use Lunr\Spark\Facebook\Authentication;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Api.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Authentication
 */
abstract class AuthenticationTest extends LunrBaseTest
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
     * Mock instance of the Request class.
     * @var RequestInterface
     */
    protected $request;

    /**
     * Mock instance of the CurlResponse class.
     * @var CurlResponse
     */
    protected $response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpNull()
    {
        $this->cas      = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->curl     = $this->getMock('Lunr\Network\Curl');
        $this->logger   = $this->getMock('Psr\Log\LoggerInterface');
        $this->request  = $this->getMock('Lunr\Corona\RequestInterface');
        $this->response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->request->expects($this->at(0))
                      ->method('get_get_data')
                      ->with($this->equalTo('state'))
                      ->will($this->returnValue(NULL));

        $this->class      = new Authentication($this->cas, $this->logger, $this->curl, $this->request);
        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Authentication');
    }

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->curl     = $this->getMock('Lunr\Network\Curl');
        $this->logger   = $this->getMock('Psr\Log\LoggerInterface');
        $this->request  = $this->getMock('Lunr\Corona\RequestInterface');
        $this->response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                               ->disableOriginalConstructor()
                               ->getMock();

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

        $this->class      = new Authentication($this->cas, $this->logger, $this->curl, $this->request);
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
        unset($this->curl);
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
