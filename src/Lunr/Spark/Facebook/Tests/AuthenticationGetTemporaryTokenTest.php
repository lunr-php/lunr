<?php

/**
 * This file contains the AuthenticationGetTemporaryTokenTest class.
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
class AuthenticationGetTemporaryTokenTest extends AuthenticationTest
{

    /**
     * Test that get_temporary_access_token() returns an empty string on request error.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenReturnsEmptyStringOnError(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 400;
        $this->response->url         = 'https://graph.facebook.com/oauth/access_token';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new Requests_Exception_HTTP_400('Not Found!'));

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

        $this->assertSame('', $this->class->get_temporary_access_token());
    }

    /**
     * Test that get_temporary_access_token() returns an empty string on request failure.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenReturnsEmptyStringOnFailure(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willThrowException(new Requests_Exception('Network error!', 'curlerror', NULL));

        $this->assertSame('', $this->class->get_temporary_access_token());
    }

    /**
     * Test that get_temporary_access_token() stores the access token in the CAS.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenStoresAccessTokenInCas(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token&expires=100000';

        $this->cas->expects($this->exactly(2))
                  ->method('add')
                  ->withConsecutive(
                      [ 'facebook', 'access_token', 'Token' ],
                      [ 'facebook', 'app_secret_proof', 'bc383bf3bab04208b0e3ba7a71e40164cc2343b0314bcca0e85018c5dc852bfe' ]
                  );

        $this->class->get_temporary_access_token();
    }

    /**
     * Test that get_temporary_access_token() stores the token expiry time.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenStoresExpiryTime(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token&expires=100000';

        $this->class->get_temporary_access_token();

        $this->assertTrue($this->get_reflection_property_value('token_expires') <= time() + 100000);
    }

    /**
     * Test that get_temporary_access_token() returns the access token on success.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenReturnsAccessTokenOnSuccess(): void
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'app_id', 'Lunr' ], [ 'facebook', 'app_secret', 'Secret' ]]);

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token&expires=100000';

        $this->assertEquals('Token', $this->class->get_temporary_access_token());
    }

}

?>
