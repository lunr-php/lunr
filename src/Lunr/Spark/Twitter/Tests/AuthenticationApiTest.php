<?php

/**
 * This file contains the AuthenticationApiTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Lunr\Spark\Twitter\Authentication;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Authentication.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Spark\Twitter\Authentication
 */
class AuthenticationApiTest extends AuthenticationTest
{
    /**
     * A sample curl options array
     * @var array
     */
    protected $options;

    /**
     * A sample curl header array
     * @var array
     */
    protected $header;

    /**
     * AuthenticationApiTest constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $this->options = [
            'CURLOPT_USERPWD' => 'Key:Secret',
            'CURLOPT_VERBOSE' => TRUE,
            'CURLOPT_SSL_VERIFYPEER' => TRUE
        ];

        $this->header = [
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            'User-Agent' => 'lunr.nl'
        ];
    }

    /**
     * Test that get_bearer_token() returns an empty string on request error.
     *
     * @covers Lunr\Spark\Twitter\Authentication::get_bearer_token
     */
    public function testGetBearerTokenReturnsErrorStringOnError()
    {
        $url    = 'https://api.twitter.com/oauth2/token';
        $params = 'grant_type=client_credentials';

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('user_agent'))
                  ->will($this->returnValue('lunr.nl'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('consumer_key'))
                  ->will($this->returnValue('Key'));

        $this->cas->expects($this->at(2))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('consumer_secret'))
                  ->will($this->returnValue('Secret'));

        $this->curl->expects($this->once())
                   ->method('set_options')
                   ->with($this->equalTo($this->options));

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo($this->header));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{"errors":[{"message":"Test twitter error","code":34}]}'));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->assertSame('', $this->class->get_bearer_token());
    }

    /**
     * Test that get_bearer_token() stores the bearer access token in the CAS.
     *
     * @covers Lunr\Spark\Twitter\Authentication::get_bearer_token
     */
    public function testGetBearerTokenStoresBearerTokenInCas()
    {
        $url    = 'https://api.twitter.com/oauth2/token';
        $params = 'grant_type=client_credentials';

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('user_agent'))
                  ->will($this->returnValue('lunr.nl'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('consumer_key'))
                  ->will($this->returnValue('Key'));

        $this->cas->expects($this->at(2))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('consumer_secret'))
                  ->will($this->returnValue('Secret'));

        $this->curl->expects($this->once())
                   ->method('set_options')
                   ->with($this->equalTo($this->options));

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo($this->header));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{"token_type":"bearer","access_token":"TOKEN"}'));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->cas->expects($this->once())
                  ->method('add')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'), $this->equalTo('TOKEN'));

        $this->assertEquals('TOKEN', $this->class->get_bearer_token());
    }

    /**
     * Test that get_bearer_token() returns the bearer access token.
     *
     * @covers Lunr\Spark\Twitter\Authentication::get_bearer_token
     */
    public function testGetBearerTokenReturnsBearerToken()
    {
        $url    = 'https://api.twitter.com/oauth2/token';
        $params = 'grant_type=client_credentials';

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('user_agent'))
                  ->will($this->returnValue('lunr.nl'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('consumer_key'))
                  ->will($this->returnValue('Key'));

        $this->cas->expects($this->at(2))
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('consumer_secret'))
                  ->will($this->returnValue('Secret'));

        $this->curl->expects($this->once())
                   ->method('set_options')
                   ->with($this->equalTo($this->options));

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo($this->header));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{"token_type":"bearer","access_token":"TOKEN"}'));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->cas->expects($this->once())
                  ->method('add')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'), $this->equalTo('TOKEN'));

        $this->assertEquals('TOKEN', $this->class->get_bearer_token());
    }

}

?>
