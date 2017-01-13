<?php

/**
 * This file contains the AuthenticationApiTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Requests_Exception;
use Requests_Exception_HTTP_400;

/**
 * This class contains the tests for the Authentication.
 *
 * @covers Lunr\Spark\Twitter\Authentication
 */
class AuthenticationApiTest extends AuthenticationTest
{
    /**
     * A sample http options array
     * @var array
     */
    protected $options;

    /**
     * A sample http header array
     * @var array
     */
    protected $headers;

    /**
     * AuthenticationApiTest constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $this->options = [
            'verify' => TRUE,
            'auth'   => [
                'Key',
                'Secret',
            ],
        ];

        $this->headers = [
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            'User-Agent'   => 'lunr.nl',
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
        $params = [ 'grant_type' => 'client_credentials' ];

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

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($this->headers), $this->equalTo($params), $this->equalTo('POST'), $this->equalTo($this->options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->body        = '{"errors":[{"message":"Test twitter error","code":34}]}';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Invalid Input!')));

        $this->assertSame('', $this->class->get_bearer_token());
    }

    /**
     * Test that get_bearer_token() returns an empty string on request failure.
     *
     * @covers Lunr\Spark\Twitter\Authentication::get_bearer_token
     */
    public function testGetBearerTokenReturnsErrorStringOnFailure()
    {
        $url    = 'https://api.twitter.com/oauth2/token';
        $params = [ 'grant_type' => 'client_credentials' ];

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

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($this->headers), $this->equalTo($params), $this->equalTo('POST'), $this->equalTo($this->options))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

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
        $params = [ 'grant_type' => 'client_credentials' ];

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

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($this->headers), $this->equalTo($params), $this->equalTo('POST'), $this->equalTo($this->options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{"token_type":"bearer","access_token":"TOKEN"}';

        $this->response->expects($this->once())
                       ->method('throw_for_status');

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
        $params = [ 'grant_type' => 'client_credentials' ];

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

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($this->headers), $this->equalTo($params), $this->equalTo('POST'), $this->equalTo($this->options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{"token_type":"bearer","access_token":"TOKEN"}';

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $this->cas->expects($this->once())
                  ->method('add')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'), $this->equalTo('TOKEN'));

        $this->assertEquals('TOKEN', $this->class->get_bearer_token());
    }

}

?>
