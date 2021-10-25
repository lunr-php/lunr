<?php

/**
 * This file contains the AuthenticationGetAppTokenTest class.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Requests_Exception;
use Requests_Exception_HTTP_400;

/**
 * This class contains the tests for the Authentication.
 *
 * @covers Lunr\Spark\Facebook\Authentication
 */
class AuthenticationGetAppTokenTest extends AuthenticationTest
{

    /**
     * Test that get_app_access_token() returns an empty string on request error.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_app_access_token
     */
    public function testGetAppAccessTokenReturnsEmptyStringOnError(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'grant_type'    => 'client_credentials',
        ];

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->url         = 'https://graph.facebook.com/oauth/access_token';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

        $body = [
            'error' => [
                'message' => 'Some error',
                'code'    => 400,
                'type'    => 'foo'
            ],
        ];

        $this->response->body = json_encode($body);

        $context = [
            'message' => 'Some error',
            'code'    => 400,
            'type'    => 'foo',
            'request' => 'https://graph.facebook.com/oauth/access_token',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);

        $this->assertSame('', $this->class->get_app_access_token());
    }

    /**
     * Test that get_app_access_token() returns an empty string on request failure.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_app_access_token
     */
    public function testGetAppAccessTokenReturnsEmptyStringOnFailure(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'grant_type'    => 'client_credentials',
        ];

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->assertSame('', $this->class->get_app_access_token());
    }

    /**
     * Test that get_app_access_token() stores the access token in the CAS.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_app_access_token
     */
    public function testGetAppAccessTokenStoresAccessTokenInCas(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'grant_type'    => 'client_credentials',
        ];

        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token';

        $this->cas->expects($this->exactly(2))
                  ->method('add')
                  ->withConsecutive(
                      [ 'facebook', 'access_token', 'Token' ],
                      [ 'facebook', 'app_secret_proof', 'bc383bf3bab04208b0e3ba7a71e40164cc2343b0314bcca0e85018c5dc852bfe' ]
                  );

        $this->class->get_app_access_token();
    }

    /**
     * Test that get_app_access_token() stores the token expiry time.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_app_access_token
     */
    public function testGetAppAccessTokenStoresExpiryTime(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'grant_type'    => 'client_credentials',
        ];

        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token';

        $this->class->get_app_access_token();

        $this->assertSame(0, $this->get_reflection_property_value('token_expires'));
    }

    /**
     * Test that get_app_access_token() returns the access token on success.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_app_access_token
     */
    public function testGetAppAccessTokenReturnsAccessTokenOnSuccess(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'grant_type'    => 'client_credentials',
        ];

        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token';

        $this->assertEquals('Token', $this->class->get_app_access_token());
    }

}

?>
