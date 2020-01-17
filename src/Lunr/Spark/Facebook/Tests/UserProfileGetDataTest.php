<?php

/**
 * This file contains the UserProfileGetDataTest class.
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
 * This class contains the tests for the Facebook UserProfile class.
 *
 * @covers Lunr\Spark\Facebook\UserProfile
 */
class UserProfileGetDataTest extends UserProfileTest
{

    /**
     * Test get_data() sets used_access_token to TRUE when using an access token for the request.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataSetsUsedAccessTokenTrueWhenUsingAccessToken(): void
    {
        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $this->cas->expects($this->at(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret_proof'))
                  ->will($this->returnValue('Proof'));

        $this->http->expects($this->any())
                   ->method('request')
                   ->will($this->returnValue($this->response));

        $this->class->get_data();

        $this->assertTrue($this->get_reflection_property_value('used_access_token'));
    }

    /**
     * Test get_data() sets used_access_token to FALSE when not using an access token for the request.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataSetsUsedAccessTokenFalseWhenNotUsingAccessToken(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $this->http->expects($this->any())
                   ->method('request')
                   ->will($this->returnValue($this->response));

        $this->class->get_data();

        $this->assertFalse($this->get_reflection_property_value('used_access_token'));
    }

    /**
     * Test get_data() uses fields for the request if they are set.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataUsesFieldsIfSet(): void
    {
        $this->set_reflection_property_value('fields', [ 'email', 'user_likes' ]);

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/me';
        $params = [ 'fields' => 'email,user_likes' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test get_data() does not use fields for the request if they are not set.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataDoesNotUseFieldsIfNotSet(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/me';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test get_data() uses the access token for the request if it is set.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataUsesAccessTokenIfPresent(): void
    {
        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $this->cas->expects($this->at(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret_proof'))
                  ->will($this->returnValue('Proof'));

        $url    = 'https://graph.facebook.com/me';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test get_data() does not use the access token for the request if it is not set.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataWhenAccessTokenNotPresent(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/me';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test that get_data() sets data when request was successful.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataSetsDataOnSuccessfulRequest(): void
    {
        $data = [ 'name' => 'Foo' ];

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/me';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($data);

        $this->class->get_data();

        $this->assertPropertySame('data', $data);
    }

    /**
     * Test that get_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataSetsDataOnFailedRequest(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/me';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataSetsDataOnRequestError(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/me';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->url         = 'https://graph.facebook.com/me';

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
            'request' => 'https://graph.facebook.com/me',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_data() fetches permissions.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::get_data
     */
    public function testGetDataFetchesPermissions(): void
    {
        $data = [
            'data' => [
                0 => [
                    'email'      => 1,
                    'user_likes' => 1,
                ],
            ],
        ];

        $this->cas->expects($this->exactly(6))
                  ->method('get')
                  ->will($this->onConsecutiveCalls('Token', 'Token', 'Proof', 'Token', 'Token', 'Token'));

        $url    = 'https://graph.facebook.com/me';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
        ];

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $url    = 'https://graph.facebook.com/me/permissions';
        $params = [ 'access_token' => 'Token' ];

        $this->http->expects($this->at(1))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($data);

        $this->class->get_data();

        $this->assertPropertyEquals('permissions', [ 'email' => 1, 'user_likes' => 1 ]);
    }

}

?>
