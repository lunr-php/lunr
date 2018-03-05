<?php

/**
 * This file contains the AuthenticationGetTemporaryTokenTest class.
 *
 * PHP Version 5.4
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
    public function testGetTemporaryAccessTokenReturnsEmptyStringOnError()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

        $this->assertSame('', $this->class->get_temporary_access_token());
    }

    /**
     * Test that get_temporary_access_token() returns an empty string on request failure.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenReturnsEmptyStringOnFailure()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->assertSame('', $this->class->get_temporary_access_token());
    }

    /**
     * Test that get_temporary_access_token() stores the access token in the CAS.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenStoresAccessTokenInCas()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token&expires=100000';

        $this->cas->expects($this->at(2))
                  ->method('add')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'), $this->equalTo('Token'));

        $this->class->get_temporary_access_token();
    }

    /**
     * Test that get_temporary_access_token() stores the token expiry time.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenStoresExpiryTime()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

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
    public function testGetTemporaryAccessTokenReturnsAccessTokenOnSuccess()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token';
        $params = [
            'client_id'     => 'Lunr',
            'client_secret' => 'Secret',
            'redirect_uri'  => 'http://localhost/controller/method/',
            'code'          => 'Code',
        ];

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = 'access_token=Token&expires=100000';

        $this->assertEquals('Token', $this->class->get_temporary_access_token());
    }

}

?>
