<?php

/**
 * This file contains the FeedGetDataTest class.
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
 * This class contains the tests for the Facebook Feed class.
 *
 * @covers Lunr\Spark\Facebook\Feed
 */
class FeedGetDataTest extends FeedTest
{

    /**
     * Test that fetch_data() calls get_permissions() and classify() after a request.
     *
     * @covers Lunr\Spark\Facebook\Feed::fetch_data
     */
    public function testFetchData(): void
    {
        $this->cas->expects($this->any())
                  ->method('get')
                  ->willReturnArgument(0);

        $params = [
            'access_token'    => 'facebook',
            'appsecret_proof' => 'facebook',
        ];

        $this->http->expects($this->exactly(2))
                   ->method('request')
                   ->withConsecutive(
                    [ 'http://localhost', [], $params, 'GET' ],
                    [ 'https://graph.facebook.com/me/permissions', [], [ 'access_token' => 'facebook' ], 'GET' ]
                    )
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertContainsOnlyInstancesOf('Lunr\Spark\Facebook\Post', $this->get_reflection_property_value('data'));
    }

    /**
     * Test get_data() does not perform an API call if the resource ID is not set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataDoesNotCallApiIfResourceIDNotSetAndNotFetchingUserData(): void
    {
        $this->cas->expects($this->never())
                  ->method('get');

        $this->http->expects($this->never())
                   ->method('request');

        $this->class->get_data();
    }

    /**
     * Test get_data() uses fields for the request if they are set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataUsesFieldsIfSet(): void
    {
        $this->set_reflection_property_value('id', 'resource');
        $this->set_reflection_property_value('fields', [ 'email', 'user_likes' ]);

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'fields' => 'email,user_likes',
            'limit'  => 25,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data();
    }

    /**
     * Test get_data() does not use fields for the request if they are not set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataDoesNotUseFieldsIfNotSet(): void
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data();
    }

    /**
     * Test get_data() uses the access token for the request if it is set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataUsesAccessTokenIfPresent(): void
    {
        $this->set_reflection_property_value('id', 'resource');
        $this->cas->expects($this->exactly(6))
                  ->method('get')
                  ->willReturnMap([[ 'facebook', 'access_token', 'Token' ], [ 'facebook', 'app_secret_proof', 'Proof' ]]);

        $params = [
            'limit'           => 25,
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
        ];

        $this->http->expects($this->exactly(2))
                   ->method('request')
                   ->withConsecutive(
                       [ 'https://graph.facebook.com/resource/feed', [], $params, 'GET' ],
                       [ 'https://graph.facebook.com/me/permissions', [], [ 'access_token' => 'Token' ], 'GET' ]
                   )
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data();
    }

    /**
     * Test get_data() does not use the access token for the request if it is not set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataWhenAccessTokenNotPresent(): void
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data();
    }

    /**
     * Test that get_data() sets data when request was successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataSetsDataOnSuccessfulRequest(): void
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data();

        $this->assertContainsOnlyInstancesOf('Lunr\Spark\Facebook\Post', $this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_data() sets data when request was successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataSetsUserDataOnSuccessfulRequest(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/me/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data(TRUE);

        $this->assertContainsOnlyInstancesOf('Lunr\Spark\Facebook\Post', $this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataSetsDataOnFailedRequest(): void
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willThrowException(new Requests_Exception('Network error!', 'curlerror', NULL));

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataSetsDataOnRequestError(): void
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 400;
        $this->response->url         = 'https://graph.facebook.com/resource/feed';

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
            'request' => 'https://graph.facebook.com/resource/feed',
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
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataFetchesPermissionsIfCheckPermissionsTrue(): void
    {
        $this->set_reflection_property_value('id', 'resource');
        $this->set_reflection_property_value('check_permissions', TRUE);

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
                  ->willReturnOnConsecutiveCalls('Token', 'Token', 'Proof', 'Token', 'Token', 'Token');

        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
            'limit'           => 25,
        ];

        $this->http->expects($this->exactly(2))
                   ->method('request')
                   ->withConsecutive(
                       [ 'https://graph.facebook.com/resource/feed', [], $params, 'GET' ],
                       [ 'https://graph.facebook.com/me/permissions', [], [ 'access_token' => 'Token' ], 'GET' ]
                   )
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = json_encode($data);

        $this->class->get_data();

        $this->assertPropertyEquals('permissions', [ 'email' => 1, 'user_likes' => 1 ]);
    }

    /**
     * Test that get_data() does not fetch permissions.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataDoesNotFetchPermissionsIfCheckPermissionsFalse(): void
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(4))
                  ->method('get')
                  ->willReturnOnConsecutiveCalls('Token', 'Token', 'Proof');

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
            'limit'           => 25,
        ];

        $this->http->expects($this->exactly(1))
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = json_encode([]);

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

    /**
     * Test that get_data() sets fetched_user_data to TRUE if we fetch the feed of a user.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataSetsFetchedUserDataTrueIfFetchingUserData(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/me/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data(TRUE);

        $this->assertTrue($this->get_reflection_property_value('fetched_user_data'));
    }

    /**
     * Test that get_data() sets fetched_user_data to FALSE if we fetch the feed of a resource.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_data
     */
    public function testGetDataSetsFetchedUserDataFalseIfFetchingResourceData(): void
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with('facebook', 'access_token')
                  ->willReturn(NULL);

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [ 'limit' => 25 ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_data();

        $this->assertFalse($this->get_reflection_property_value('fetched_user_data'));
    }

}

?>
